<?php

namespace App\Extensions\FashionStudio\System\Http\Controllers;

use App\Domains\Entity\Enums\EntityEnum;
use App\Domains\Entity\Facades\Entity;
use App\Extensions\FashionStudio\System\Enums\ImageStatusEnum;
use App\Extensions\FashionStudio\System\Jobs\CheckFalAIGenerationJob;
use App\Extensions\FashionStudio\System\Models\FashionStudioUserSetting;
use App\Extensions\FashionStudio\System\Services\FashionStudioFalAIService;
use App\Helpers\Classes\Helper;
use App\Http\Controllers\Controller;
use App\Models\OpenAIGenerator;
use App\Models\Usage;
use App\Models\UserOpenai;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class BaseFashionStudioController extends Controller
{
    protected const EDIT_MODEL = EntityEnum::NANO_BANANA_PRO_EDIT;

    public function __construct(
        protected FashionStudioFalAIService $falAIService
    ) {}

    /**
     * Get the title for the generation record
     */
    abstract protected function getGenerationTitle(): string;

    /**
     * Get the slug suffix for the generation record
     */
    abstract protected function getSlugSuffix(): string;

    /**
     * Get the prompt for AI generation
     */
    abstract protected function getPrompt(): string;

    /**
     * Get image URLs from the request for AI generation
     */
    abstract protected function getImageUrls(): array;

    /**
     * Get the response key name for status endpoint
     */
    abstract protected function getResponseKey(): string;

    /**
     * Get the number of images to generate (default 1)
     */
    protected function getNumImages(): int
    {
        return 1;
    }

    /**
     * Get credits per image (default 1)
     */
    protected function getCreditsPerImage(): int
    {
        return 1;
    }

    /**
     * Get the user's Fashion Studio settings
     */
    protected function getUserSettings(): FashionStudioUserSetting
    {
        return FashionStudioUserSetting::getForUser(Auth::id());
    }

    /**
     * Get image size options from user settings
     */
    protected function getImageSizeOptions(): array
    {
        $settings = $this->getUserSettings();

        return $settings->getImageSize();
    }

    /**
     * Create database record for the generation
     */
    protected function createRecord(array $payloadData, int $imageIndex = 0): UserOpenai
    {
        $user = Auth::user();

        $record = UserOpenai::create([
            'team_id'   => $user?->team_id,
            'title'     => $this->getGenerationTitle() . ($imageIndex > 0 ? " #{$imageIndex}" : ''),
            'slug'      => Str::random(7) . Str::slug($user?->fullName()) . '-' . $this->getSlugSuffix() . ($imageIndex > 0 ? "-{$imageIndex}" : ''),
            'user_id'   => $user?->id,
            'openai_id' => OpenAIGenerator::where('slug', 'ai_image_generator')->first()?->id,
            'payload'   => $payloadData,
            'input'     => null,
            'response'  => 'FS',
            'output'    => null,
            'hash'      => str()->random(256),
            'credits'   => $this->getCreditsPerImage(),
            'words'     => 0,
            'storage'   => 'public',
            'status'    => ImageStatusEnum::pending->value,
            'model'     => self::EDIT_MODEL,
            'engine'    => self::EDIT_MODEL->engine()->value,
        ]);

        $record->is_fashion_studio = true;
        $record->save();

        return $record;
    }

    /**
     * Upload file securely and return the path
     */
    protected function uploadFile($file): string
    {
        $user = Auth::user();
        $folderPath = 'media/images/u-' . $user?->id;

        return processSecureFileUpload($file, $folderPath);
    }

    /**
     * Generate image with AI
     */
    protected function generateWithAI(UserOpenai $record): void
    {
        try {
            $prompt = $this->getPrompt();
            $imageUrls = $this->getImageUrls();
            $numImages = $this->getNumImages();
            $imageSize = $this->getImageSizeOptions();

            $requestId = $this->falAIService::generate($prompt, $imageUrls, $numImages, $imageSize);

            // Handle payload - it's cast to array, so access it directly
            $existPayload = is_array($record->payload) ? $record->payload : [];
            $existPayload['uuid'] = $requestId;

            $record->update([
                'status'  => ImageStatusEnum::processing->value,
                'payload' => $existPayload,
            ]);

            // Dispatch job to check generation status
            CheckFalAIGenerationJob::dispatch($record->id, 'image')->delay(now()->addSeconds(5));
        } catch (Exception $e) {
            Log::error($this->getGenerationTitle() . ' failed', [
                'record_id' => $record->id,
                'error'     => $e->getMessage(),
                'trace'     => $e->getTraceAsString(),
            ]);

            $record->update(['status' => ImageStatusEnum::failed->value]);
        }
    }

    /**
     * Check generation status with AI and create duplicate records for multiple images
     */
    protected function checkWithAI(UserOpenai $record): array
    {
        // Payload is cast to array, access it directly
        $payloadData = is_array($record->payload) ? $record->payload : [];
        $uuid = $payloadData['uuid'] ?? null;
        $response = $this->falAIService::check($uuid);

        if ($response) {
            // Handle multiple images by creating separate records
            $images = data_get($response, 'images', []);

            if (empty($images)) {
                // Fallback to single image format
                $image = data_get($response, 'image.url');
                $images = [$image];
            }

            $createdRecords = [];

            // Download and save the first image locally
            $localPath = $this->downloadAndSaveFile($images[0]);

            if ($localPath) {
                $record->update([
                    'status' => ImageStatusEnum::completed->value,
                    'output' => $localPath,
                ]);
                $createdRecords[] = $record;

                // Create duplicate records for additional images
                for ($i = 1; $i < count($images); $i++) {
                    $additionalLocalPath = $this->downloadAndSaveFile($images[$i]);

                    if (! $additionalLocalPath) {
                        continue;
                    }

                    $duplicateRecord = $this->createRecord($payloadData, $i + 1);

                    $duplicateRecord->update([
                        'status'  => ImageStatusEnum::completed->value,
                        'output'  => $additionalLocalPath,
                        'payload' => $payloadData,
                    ]);

                    $createdRecords[] = $duplicateRecord;
                }
            }

            return $createdRecords;
        }

        return [$record];
    }

    /**
     * Download file from URL and save it locally
     */
    protected function downloadAndSaveFile(string $url, ?string $defaultExtension = null): ?string
    {
        try {
            $response = Http::timeout(120)->get($url);

            if ($response->successful()) {
                $extension = $defaultExtension ?? pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'png';
                $fileName = Str::uuid() . '.' . $extension;
                $path = 'media/images/u-' . auth()->id() . '/' . $fileName;

                Storage::disk('public')->put($path, $response->body());

                return '/uploads/' . $path;
            }
        } catch (Exception $e) {
            Log::error('BaseFashionStudioController: Error downloading file', [
                'url'   => $url,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * Common status endpoint logic - checks database status (job updates the record)
     */
    public function status(string $id): JsonResponse
    {
        $record = UserOpenai::where('user_id', Auth::id())->findOrFail($id);

        $response = [
            'status' => $record->status,
        ];

        if ($record->status === ImageStatusEnum::completed->value) {
            $results = [[
                'id'         => $record->id,
                'image_url'  => $record->output,
                'created_at' => $record->created_at->toISOString(),
            ]];

            // Find related records (same UUID in payload) created for additional images
            $payload = is_array($record->payload) ? $record->payload : (json_decode((string) $record->payload, true) ?: []);
            $uuid = $payload['uuid'] ?? null;

            if ($uuid) {
                // Use flexible LIKE patterns to match JSON regardless of spacing
                $relatedRecords = UserOpenai::where('user_id', Auth::id())
                    ->where('id', '!=', $record->id)
                    ->where(function ($query) use ($uuid) {
                        $query->where('payload', 'like', '%"uuid":"' . $uuid . '"%')
                            ->orWhere('payload', 'like', '%"uuid": "' . $uuid . '"%');
                    })
                    ->where('status', ImageStatusEnum::completed->value)
                    ->orderBy('id')
                    ->get();

                foreach ($relatedRecords as $relatedRecord) {
                    $results[] = [
                        'id'         => $relatedRecord->id,
                        'image_url'  => $relatedRecord->output,
                        'created_at' => $relatedRecord->created_at->toISOString(),
                    ];
                }
            }

            $response['results'] = $results;
        } elseif ($record->status === ImageStatusEnum::failed->value) {
            $response['message'] = __('Generation failed. Please try again.');
        }

        return response()->json($response);
    }

    /**
     * Common destroy endpoint logic
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $record = UserOpenai::where('user_id', Auth::id())->findOrFail($id);

            if ($record->output) {
                $relativePath = Str::after($record->output, '/uploads/');
                Storage::disk('public')->delete($relativePath);
            }

            $record->delete();

            return response()->json([
                'success' => true,
                'message' => __('Image deleted successfully'),
            ]);

        } catch (Exception $e) {
            Log::error(__('Failed to delete image'), [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to delete image'),
            ], 500);
        }
    }

    /**
     * Get the demo limit feature name for rate limiting
     */
    protected function getDemoLimitFeature(): string
    {
        return 'default';
    }

    /**
     * Get the maximum demo attempts allowed per day
     */
    protected function getDemoMaxAttempts(): int
    {
        return 3;
    }

    /**
     * Common generate endpoint logic
     */
    protected function processGeneration(string $lockKey, array $payloadData): JsonResponse
    {
        $demoLimitResponse = Helper::checkFashionStudioDemoLimit(
            $this->getDemoLimitFeature(),
            $this->getDemoMaxAttempts()
        );

        if ($demoLimitResponse !== null) {
            return $demoLimitResponse;
        }

        try {
            if (! Cache::lock($lockKey, 10)->get()) {
                return response()->json([
                    'message' => __('Another editing in progress. Please try again later.'),
                ], 409);
            }

            $numImages = $this->getNumImages();

            $driver = Entity::driver(self::EDIT_MODEL)
                ->inputImageCount($numImages)
                ->calculateCredit();

            if (! $driver->hasCreditBalanceForInput()) {
                return response()->json([
                    'success' => false,
                    'message' => __('You do not have enough credits. You need :credits credits to generate :count image(s).', [
                        'credits' => $driver->getCalculatedInputCredit(),
                        'count'   => $numImages,
                    ]),
                ], 402);
            }

            $record = $this->createRecord($payloadData);
            $this->generateWithAI($record);

            Usage::getSingle()->updateImageCounts($driver->calculate());
            $driver->decreaseCredit();
            Cache::lock($lockKey)->release();

            return response()->json([
                'id'      => $record->id,
                'success' => true,
                'message' => __($this->getGenerationTitle() . ' started'),
            ]);

        } catch (Exception $e) {
            Log::error($this->getGenerationTitle() . ' failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => __('Failed to start generation: ' . $e->getMessage()),
            ], 500);

        } finally {
            Cache::lock($lockKey)->forceRelease();
        }
    }
}

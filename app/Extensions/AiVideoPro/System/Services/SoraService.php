<?php

declare(strict_types=1);

namespace App\Extensions\AiVideoPro\System\Services;

use App\Helpers\Classes\ApiHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class SoraService
{
    public const SORA_ENDPOINT = 'https://api.openai.com/v1/videos';

    public static function generate(array $param)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 540);

        $multipart = [
            ['name' => 'model', 'contents' => $param['model']],
            ['name' => 'prompt', 'contents' => $param['prompt']],
            ['name' => 'seconds', 'contents' => (string) $param['seconds']],
            ['name' => 'size', 'contents' => $param['size'] ?? '720x1280'],
        ];

        if (isset($param['image_url']) && $param['image_url']) {
            $file = $param['image_url'];
            $mimeType = $file->getMimeType();

            $multipart[] = [
                'name'     => 'input_reference',
                'contents' => fopen($file->getRealPath(), 'rb'),
                'filename' => $file->getClientOriginalName(),
                'headers'  => [
                    'Content-Type' => $mimeType,
                ],
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . ApiHelper::setOpenAIKey(),
        ])->asMultipart()
            ->post(self::SORA_ENDPOINT, $multipart);

        return $response->json();
    }

    public static function getStatus(?string $id)
    {
        ini_set('max_execution_time', 440);
        set_time_limit(0);

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . ApiHelper::setOpenAiKey(),
        ])->get(self::SORA_ENDPOINT . '/' . $id);

        return $response->json();
    }

    public static function getVideo(?string $id): string
    {
        ini_set('max_execution_time', 440);
        set_time_limit(0);

        $endpoint = self::SORA_ENDPOINT . '/' . $id . '/content';
        $apiKey = ApiHelper::setOpenAiKey();
        $userId = auth()->id();

        // Example: sora_video_abc123.mp4
        $fileName = "sora_video_{$id}.mp4";
        $relativePath = "media/videos/u-{$userId}/{$fileName}";
        $absolutePath = Storage::disk('uploads')->path($relativePath);

        // Ensure directory exists
        if (! is_dir(dirname($absolutePath)) && ! mkdir($concurrentDirectory = dirname($absolutePath), 0755, true) && ! is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }

        // Stream MP4 directly to file (no buffering)
        Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Accept'        => 'application/octet-stream',
        ])->sink($absolutePath)->get($endpoint);

        // Return full public URL to video
        return Storage::disk('uploads')->url($relativePath);
    }
}

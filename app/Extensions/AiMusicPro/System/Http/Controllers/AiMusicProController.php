<?php

namespace App\Extensions\AiMusicPro\System\Http\Controllers;

use App\Domains\Entity\Enums\EntityEnum;
use App\Domains\Entity\Facades\Entity;
use App\Extensions\AiMusicPro\System\Models\AiMusicPro;
use App\Helpers\Classes\ApiHelper;
use App\Helpers\Classes\Helper;
use App\Http\Controllers\Controller;
use App\Packages\Elevenlabs\ElevenlabsService as PackageElevenlabsService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AiMusicProController extends Controller
{
    public function __construct()
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 36000);
    }

    public function index(): View
    {
        $music = AiMusicPro::where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(10);

        return view('ai-music-pro::index', compact('music'));
    }

    public function generate(Request $request): JsonResponse
    {
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 36000);

        $request->validate([
            'workbook_title'  => 'required|string|max:190',
            'ai_music_prompt' => 'required|string|max:2000',
            'duration'        => 'nullable|integer|min:10|max:300',
            'music_style'     => 'nullable|string|max:190',
        ]);
        $isDemo = Helper::appIsDemo();
        // --- DEMO MODE CHECK (BEFORE GENERATION) ---
        if ($isDemo) {
            $duration = (int) $request->get('duration', 30); // Assume 30 seconds if not specified
            $chkLmt = Helper::checkDemoSecondDailyLimit($duration);
            if ($chkLmt->getStatusCode() === 429) {
                return response()->json(['message' => $chkLmt->getData()->message, 'type' => 'error']);
            }
        }

        $driver = Entity::driver(EntityEnum::ELEVENLABS_AI_MUSIC)->inputMinute(1)->calculateCredit();

        try {
            $driver->redirectIfNoCreditBalance();
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage(), 'type' => 'error']);
        }

        $param = [
            'prompt'   => $request->get('ai_music_prompt', ''),
            'model_id' => 'music_v1',
        ];

        if ($request->filled('duration')) {
            $param['music_length_ms'] = $request->get('duration') * 1000;
        }

        if ($request->filled('music_style')) {
            $param['prompt'] .= ', in the style of ' . $request->get('music_style');
        }

        $elevenlabsService = new PackageElevenlabsService(ApiHelper::setElevenlabsKey());
        $response = $elevenlabsService->AiMusicModel()->submit($param);

        $fileUrl = $response->getData(true)['file_url'] ?? null;

        if (empty($fileUrl)) {
            return response()->json(['message' => __('Failed to generate music. Please try again.'), 'type' => 'error']);
        }

        $uploadsPath = public_path('uploads/' . $fileUrl);

        if ($request->filled('duration')) {
            $voiceLengthMinutes = $request->get('duration') / 60;
        } else {
            $voiceLengthMinutes = measureVoiceLength($uploadsPath);
        }

        $driver->inputMinute($voiceLengthMinutes)->calculateCredit()->decreaseCredit();

        $this->storeMusicRecord(
            $fileUrl,
            $param,
            $request->get('workbook_title', 'Song Title'),
            $voiceLengthMinutes
        );

        // --- DEMO MODE: RECORD USED TIME (AFTER GENERATION) ---
        if ($isDemo) {
            $clientIp = Helper::getRequestIp();
            $cacheKey = "demo_ai_usage_seconds_{$clientIp}";
            $usedSeconds = Cache::get($cacheKey, 0);
            $newTotal = $usedSeconds + ($voiceLengthMinutes * 60); // Convert minutes to seconds
            Cache::put($cacheKey, $newTotal, now()->endOfDay());
        }

        $music = AiMusicPro::where('user_id', auth()->id())->orderBy('id', 'desc')->paginate(10);
        $html2 = view('ai-music-pro::components.generator_sidebar_table', compact('music'))->render();

        return response()->json([
            'status'   => 'success',
            'message'  => __('Music generated successfully!'),
            'html2'    => $html2,
        ]);
    }

    private function storeMusicRecord($fileUrl, $param, $title, $voiceLengthMinutes): void
    {
        $voiceLengthSeconds = null;

        if ($voiceLengthMinutes !== null) {
            $voiceLengthSeconds = $voiceLengthMinutes / 60;
        } elseif (! empty($param['music_length_ms'])) {
            $voiceLengthSeconds = $param['music_length_ms'] / 1000;
        }

        $data = [
            'user_id'         => auth()->id(),
            'file_path'       => $fileUrl ?? null,
            'workbook_title'  => $title,
            'ai_music_prompt' => $param['prompt'] ?? null,
            'duration'        => $voiceLengthSeconds,
            'music_style'     => $param['music_style'] ?? null,
        ];

        AiMusicPro::create($data);
    }

    public function delete($id): RedirectResponse
    {
        $music = AiMusicPro::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        try {
            if (file_exists(public_path('uploads/' . $music->file_path))) {
                @unlink(public_path('uploads/' . $music->file_path));
            }

            $music->delete();

            return redirect()->back()->with(['message' => __('Music deleted successfully!'), 'type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => __('Failed to delete music. Please try again.'), 'type' => 'error']);
        }
    }
}

<?php

namespace App\Extensions\SocialMediaAgent\System\Http\Controllers;

use App\Extensions\SocialMedia\System\Models\SocialMediaAnalysis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class SocialMediaAgentAnalysisController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $query = SocialMediaAnalysis::query()
            ->with('agent:id,name')
            ->where('user_id', $user->id);

        if ($request->filled('type')) {
            $query->where('type', trim((string) $request->input('type')));
        }

        if ($agentId = $request->input('agent_id')) {
            $query->where('agent_id', $agentId);
        }

        if ($request->boolean('unread')) {
            $query->whereNull('read_at');
        }

        $perPage = min(max((int) $request->input('per_page', 10), 1), 50);
        $unreadCount = (clone $query)->whereNull('read_at')->count();

        $analyses = $query
            ->orderByDesc('created_at')
            ->paginate($perPage);

        $data = $analyses->getCollection()
            ->map(fn (SocialMediaAnalysis $analysis) => $this->transform($analysis))
            ->values();

        return response()->json([
            'data' => $data,
            'meta' => [
                'current_page' => $analyses->currentPage(),
                'last_page'    => $analyses->lastPage(),
                'per_page'     => $analyses->perPage(),
                'total'        => $analyses->total(),
                'unread_count' => $unreadCount,
            ],
        ]);
    }

    public function show(Request $request, SocialMediaAnalysis $analysis): JsonResponse
    {
        $this->authorizeAccess($request, $analysis);

        if ($request->boolean('mark_as_read')) {
            $analysis->markAsRead();
            $analysis->refresh();
        }

        return response()->json([
            'data' => $this->transform($analysis),
        ]);
    }

    public function markAsRead(Request $request, SocialMediaAnalysis $analysis): JsonResponse
    {
        $this->authorizeAccess($request, $analysis);

        $analysis->markAsRead();
        $analysis->refresh();

        return response()->json([
            'data' => $this->transform($analysis),
        ]);
    }

    public function destroy(Request $request, SocialMediaAnalysis $analysis): JsonResponse
    {
        $this->authorizeAccess($request, $analysis);

        $analysis->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function clearAll(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $deleted = SocialMediaAnalysis::query()
            ->where('user_id', $userId)
            ->delete();

        return response()->json([
            'status'  => 'success',
            'deleted' => $deleted,
        ]);
    }

    private function authorizeAccess(Request $request, SocialMediaAnalysis $analysis): void
    {
        if ($analysis->user_id !== $request->user()->id) {
            abort(404);
        }
    }

    private function transform(SocialMediaAnalysis $analysis): array
    {
        $link = null;

        return [
            'id'             => $analysis->id,
            'type'           => $analysis->type,
            'type_label'     => Str::headline(str_replace('_', ' ', $analysis->type)),
            'agent_id'       => $analysis->agent_id,
            'agent_name'     => $analysis->agent?->name,
            'agent_image'    => $analysis->agent?->image,
            'report_text'    => $analysis->report_text,
            'summary'        => $analysis->summary,
            'report_excerpt' => Str::limit(strip_tags($analysis->report_text), 220),
            'created_at'     => optional($analysis->created_at)->toIso8601String(),
            'read_at'        => optional($analysis->read_at)->toIso8601String(),
            'is_unread'      => $analysis->read_at === null,
            'link'           => route('dashboard.user.social-media.agent.chat.index', ['id' => $analysis->agent_id, 'analysis' => $analysis->id]),
        ];
    }
}

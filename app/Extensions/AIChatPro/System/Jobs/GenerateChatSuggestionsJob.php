<?php

namespace App\Extensions\AIChatPro\System\Jobs;

use App\Models\UserOpenaiChatMessage;
use App\Services\Ai\AiCompletionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class GenerateChatSuggestionsJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private const SYSTEM_PROMPT = <<<'PROMPT'
        You are an expert AI chat assistant.

        Based on the user's message and the AI response, generate:
        1. A short friendly brief of what the suggestions are about (1 sentence).
        2. An array of 4 short, actionable follow-up suggestions the user might want to ask next.

        STRICT OUTPUT RULES:
        - Return ONLY valid JSON
        - No markdown
        - No explanations
        - No extra text
        - No additional keys

        JSON FORMAT (must match exactly):
        {
          "brief": "short friendly sentence about the suggestions",
          "suggestions": ["Suggestion 1","Suggestion 2","Suggestion 3","Suggestion 4"]
        }

        Suggestions rules:
        - 2–6 words each
        - Relevant follow-up questions or topics
        - Concrete and actionable
        - Diverse range of follow-up directions
        - Written as short prompts the user would type

        Example:
        {
          "brief": "If you want, I can:",
          "suggestions": ["Make a shorter version","Rewrite for email","Make it more dramatic","Adapt it to your Brand"]
        }
        PROMPT;

    private const DEFAULT_PAYLOAD = [
        'brief'       => 'If you want, I can:',
        'suggestions' => [
            'Make a shorter version',
            'Rewrite for email',
            'Make it more dramatic',
            'Adapt it to your Brand',
        ],
    ];

    public function __construct(protected int $messageId) {}

    public function handle(): void
    {
        $message = UserOpenaiChatMessage::find($this->messageId);

        if (! $message) {
            Log::warning('Chat suggestion generation: message not found', [
                'message_id' => $this->messageId,
            ]);

            return;
        }

        $this->generateSuggestions($message);
    }

    private function generateSuggestions(UserOpenaiChatMessage $message): void
    {
        $userInput = $message->input ?? '';
        $aiResponse = mb_substr($message->output ?? '', 0, 500);
        $userContent = "User message: {$userInput}.\n\n AI response (truncated): {$aiResponse}";

        try {
            $responseText = app(AiCompletionService::class)->complete(self::SYSTEM_PROMPT, $userContent);

            $payload = json_decode($responseText, true, 512, JSON_THROW_ON_ERROR);

            if (
                ! isset($payload['brief'], $payload['suggestions']) ||
                ! is_array($payload['suggestions']) ||
                count($payload['suggestions']) !== 4
            ) {
                throw new RuntimeException('Invalid AI response structure.');
            }
        } catch (Throwable $e) {
            Log::warning('Chat suggestion generation failed, using defaults', [
                'message_id' => $message->id,
                'error'      => $e->getMessage(),
            ]);

            $payload = self::DEFAULT_PAYLOAD;
        }

        $message->update([
            'suggestions_response' => $payload,
        ]);
    }
}

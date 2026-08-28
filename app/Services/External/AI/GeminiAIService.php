<?php

namespace App\Services\External\AI;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GeminiAIService implements AIServiceInterface
{
    public function generateReply(string $message, array $history = []): string
    {
        $apiKey = (string) config('services.gemini.api_key');
        if ($apiKey === '') throw new RuntimeException('GEMINI_API_KEY no está configurada.');

        $contents = array_map(fn (array $entry): array => [
            'role' => $entry['sender'] === 'bot' ? 'model' : 'user',
            'parts' => [['text' => $entry['message']]],
        ], $history);
        $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];
        $model = (string) config('services.gemini.model', 'gemini-2.0-flash');
        $url = sprintf('https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent', rawurlencode($model));

        try {
            $response = Http::timeout(8)->acceptJson()->withHeaders([
                'x-goog-api-key' => $apiKey,
            ])->post($url, [
                'contents' => $contents,
                'generationConfig' => ['temperature' => 0.2, 'maxOutputTokens' => 300],
            ]);
            $response->throw();
        } catch (RequestException $exception) {
            throw new RuntimeException('Gemini devolvió un error HTTP.', 0, $exception);
        }

        $text = $response->json('candidates.0.content.parts.0.text');
        if (! is_string($text) || trim($text) === '') throw new RuntimeException('Gemini devolvió una respuesta inválida.');
        return trim($text);
    }
}

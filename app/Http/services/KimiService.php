<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KimiService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.moonshot.cn/v1';

    public function __construct()
    {
        $this->apiKey = config('services.kimi.api_key');
    }

    public function translateToEnglish(string $text): string
    {
        if (empty($this->apiKey)) {
            Log::warning('Kimi API key not configured');
            return $text;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'kimi-k2.5',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a professional translator. Translate the following Indonesian text to English. Keep the meaning, tone, and structure intact. Only return the translated text, nothing else.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $text
                    ]
                ],
                'temperature' => 0.3,
                'max_tokens' => 4096,
            ]);

            if ($response->successful()) {
                $translated = $response->json('choices.0.message.content');
                return $translated ?? $text;
            }

            Log::error('Kimi translation failed', [
                'status' => $response->status(),
                'response' => $response->body(),
            ]);

            return $text;

        } catch (\Exception $e) {
            Log::error('Kimi translation error: ' . $e->getMessage());
            return $text;
        }
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }
}
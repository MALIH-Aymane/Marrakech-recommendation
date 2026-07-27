<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class GeminiEmbeddingService
{
    public function embedImage(string $imagePath): array
    {
        $apiKey = config('services.gemini.key');

        $image = base64_encode(file_get_contents($imagePath));

        $mime = mime_content_type($imagePath);

        $response = Http::withHeaders([
            'x-goog-api-key' => $apiKey,
        ])->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-2:embedContent',
            [
                "content" => [
                    "parts" => [
                        [
                            "inline_data" => [
                                "mime_type" => $mime,
                                "data" => $image
                            ]
                        ]
                    ]
                ]
            ]
        );

        if (!$response->successful()) {
    throw new \Exception($response->body());
}

return $response->json()['embedding']['values'];
    }
}
<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class GeminiVisionService
{

    public function analyzeImage(string $imagePath)
    {

        $image = base64_encode(file_get_contents($imagePath));

        $apiKey = config('services.gemini.key');

      $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite:generateContent?key={$apiKey}";
        
        $response = Http::timeout(60)->post($url, [

    "contents" => [

        [

            "parts" => [

                [

                    "text" =>
                    "Describe this tourist attraction in a few keywords only.
                     Mention only what is visible.
                     Example:
                     garden, flowers, trees, fountain"

                ],

                [

                    "inline_data" => [

                        "mime_type" => "image/jpeg",

                        "data" => $image

                    ]

                ]

            ]

        ]

    ]

]);
return $response->json();
    }

}
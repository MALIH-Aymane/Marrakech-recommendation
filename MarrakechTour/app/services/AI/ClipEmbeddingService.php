<?php

namespace App\Services\AI;

class ClipEmbeddingService
{
    public function embedImage(string $imagePath): array
    {
        $python = base_path('ai_env/Scripts/python.exe');

        $script = base_path('ai/search_image.py');

        $command = "\"{$python}\" \"{$script}\" \"{$imagePath}\"";

        $output = shell_exec($command);

        return json_decode($output, true);
    }
}
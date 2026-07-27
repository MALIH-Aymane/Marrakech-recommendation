<?php

namespace App\Services\AI;

use App\Models\AttractionEmbedding;
use App\Models\Attraction;

class ImageSearchService
{
    public function search(array $queryEmbedding, int $limit = 10)
    {
        $scores = [];

        $embeddings = AttractionEmbedding::all();

        foreach ($embeddings as $embedding) {

            $vector = $embedding->embedding;

            $score = $this->cosineSimilarity(
                $queryEmbedding,
                $vector
            );

            $scores[] = [
                'attraction_id' => $embedding->attraction_id,
                'score' => $score
            ];
        }

        usort($scores, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        $scores = array_slice($scores, 0, $limit);

        $results = [];

        foreach ($scores as $score) {

            $attraction = Attraction::with('images')->find($score['attraction_id']);

            if ($attraction) {

                $attraction->similarity = round($score['score'], 4);

                $results[] = $attraction;
            }
        }

        return collect($results)->values();
    }

    private function cosineSimilarity(array $a, array $b): float
    {
        $dot = 0;
        $normA = 0;
        $normB = 0;

        $count = count($a);

        for ($i = 0; $i < $count; $i++) {

            $dot += $a[$i] * $b[$i];

            $normA += $a[$i] * $a[$i];

            $normB += $b[$i] * $b[$i];
        }

        if ($normA == 0 || $normB == 0) {
            return 0;
        }

        return $dot / (sqrt($normA) * sqrt($normB));
    }
}
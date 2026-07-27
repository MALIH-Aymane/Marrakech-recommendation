<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attraction;
use App\Models\AttractionEmbedding;
use App\Services\AI\ClipEmbeddingService;

class GenerateAttractionEmbeddings extends Command
{
    protected $signature = 'ai:generate-embeddings';

    protected $description = 'Generate embeddings for all attractions';

    public function handle(ClipEmbeddingService $clip)
    {
        $attractions = Attraction::with('images')->get();

        foreach ($attractions as $attraction) {

            // Ne pas retraiter une attraction déjà vectorisée
            if (AttractionEmbedding::where('attraction_id', $attraction->id)->exists()) {
                $this->info("Skipping : ".$attraction->attraction);
                continue;
            }

            $this->info("Processing : ".$attraction->attraction);

            $vectors = [];

            foreach ($attraction->images as $image) {

                $path = storage_path('app/public/'.$image->image);

                if (!file_exists($path)) {
                    $this->warn("Image not found : ".$path);
                    continue;
                }

                try {

                    $vector = $clip->embedImage($path);

                    if (!is_array($vector) || count($vector) == 0) {
                        $this->warn("Embedding failed.");
                        continue;
                    }

                    $vectors[] = $vector;

                } catch (\Exception $e) {

                    $this->error($e->getMessage());

                }

            }

            if (count($vectors) == 0) {
                continue;
            }

            $average = [];

            $dimension = count($vectors[0]);

            for ($i = 0; $i < $dimension; $i++) {

                $sum = 0;

                foreach ($vectors as $vector) {
                    $sum += $vector[$i];
                }

                $average[] = $sum / count($vectors);

            }

            AttractionEmbedding::create([
                'attraction_id' => $attraction->id,
                'embedding' => $average
            ]);

            $this->info("Saved.");
        }

        $this->info("Finished !");
    }
}
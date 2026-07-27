<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attraction;
use App\Models\AttractionImage;
use Illuminate\Support\Facades\DB;

class ImportTripadvisorAttractions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-tripadvisor-attractions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Tripadvisor attractions and images';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $csvPath = storage_path('app/public/tripadvisor_marrakech_attractions.csv');

    if (!file_exists($csvPath)) {

        $this->error('CSV introuvable.');
        return;

    }

    $handle = fopen($csvPath, 'r');

    // Lecture de l'entête
   $header = fgetcsv($handle, 0, ",", '"');

while (($row = fgetcsv($handle, 0, ",", '"')) !== false) {

if (count($row) != count($header)) {

    $this->warn("Ligne ignorée : nombre de colonnes incorrect.");

    continue;
}

    $data = array_combine($header, $row);
    $rate = is_numeric($data['rate'])
    ? $data['rate']
    : null;
if (is_null($rate)) {

    $this->warn("Attraction sans note : ".$data['attraction']);

}
$reviews = preg_replace('/[^0-9]/', '', $data['reviews']);

$reviews = $reviews == '' ? null : $reviews;

    $uuid = trim($data['uuid']);

$name = trim(preg_replace('/^\d+\.\s*/', '', $data['attraction']));

/*
|--------------------------------------------------------------------------
| Recherche par nom (et non plus par UUID)
|--------------------------------------------------------------------------
*/

$search = strtolower($name);

$attraction = Attraction::whereRaw('LOWER(attraction) LIKE ?', ['%'.$search.'%'])
    ->orWhereRaw('? LIKE CONCAT("%", LOWER(attraction), "%")', [$search])
    ->first();

/*
|--------------------------------------------------------------------------
| Si elle existe déjà, on la met à jour
|--------------------------------------------------------------------------
*/

if ($attraction) {

    $attraction->update([

        'uuid'           => $uuid,
        'rate'           => $rate ?? $attraction->rate,
        'reviews'        => $reviews ?? $attraction->reviews,
        'details'        => $data['details'] ?: $attraction->details,
        'attraction_url' => $data['attraction_url'] ?? $attraction->attraction_url,
        'reviews_url'    => $data['reviews_url'] ?? $attraction->reviews_url,

    ]);

}

/*
|--------------------------------------------------------------------------
| Sinon on crée une nouvelle attraction
|--------------------------------------------------------------------------
*/

else {

    $attraction = Attraction::create([

        'uuid'           => $uuid,
        'attraction'     => $name,
        'rate'           => $rate,
        'reviews'        => $reviews,
        'details'        => $data['details'],
        'attraction_url' => $data['attraction_url'],
        'reviews_url'    => $data['reviews_url'],

    ]);

}

    /*
    |--------------------------------------
    | Dossier contenant les images
    |--------------------------------------
    */

    $folder = storage_path('app/public/2026/'.$uuid);

    if (!is_dir($folder)) {

        continue;

    }

    /*
    |--------------------------------------
    | Toutes les images
    |--------------------------------------
    */

    $images = glob($folder.'/*.jpg');

    foreach ($images as $image) {

        $relativePath = '2026/'.$uuid.'/'.basename($image);

        AttractionImage::firstOrCreate(

    [

        'attraction_id' => $attraction->id,

        'image' => $relativePath,

    ],

    [

        'source' => 'tripadvisor',

    ]

);

    }

}

    fclose($handle);

    $this->info('Import terminé.');
}
}

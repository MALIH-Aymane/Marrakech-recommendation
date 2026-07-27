<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ImportLegacyPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-legacy-photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
{
    $attractions = \App\Models\Attraction::whereNotNull('photo')->get();

    foreach ($attractions as $attraction) {

        \App\Models\AttractionImage::firstOrCreate(

            [
                'attraction_id' => $attraction->id,
                'image' => $attraction->photo,
            ],

            [
                'source' => 'legacy',
            ]

        );

    }

    $this->info('Legacy photos imported successfully.');
}
}

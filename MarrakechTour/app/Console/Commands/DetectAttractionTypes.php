<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attraction;

class DetectAttractionTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'detect:types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Détecte automatiquement le type des attractions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = 0;

        $keywords = [

            'garden'      => 'Jardin',
            'majorelle'   => 'Jardin',

            'palace'      => 'Palais',

            'museum'      => 'Musée',
            'museum of'   => 'Musée',

            'medersa'     => 'Médersa',

            'mosque'      => 'Mosquée',

            'souk'        => 'Souk',
            'market'      => 'Marché',

            'square'      => 'Place',

            'desert'      => 'Désert',
            'sahara'      => 'Désert',
            'agafay'      => 'Désert',

            'atlas'       => 'Montagne',
            'mountain'    => 'Montagne',

            'waterfall'   => 'Cascade',
            'valley'      => 'Vallée',

            'camel'       => 'Balade à dos de chameau',

            'quad'        => 'Quad',
            'buggy'       => 'Buggy',

            'bike'        => 'Vélo',
            'cycling'     => 'Vélo',

            'spa'         => 'Spa',

            'park'        => 'Parc',

            'zoo'         => 'Zoo',

            'lake'        => 'Lac',

            'food'        => 'Gastronomie',
            'restaurant'  => 'Restaurant',

            'cooking'     => 'Cuisine',

            'hot air'     => 'Montgolfière',
            'balloon'     => 'Montgolfière',

            'horse'       => 'Équitation',

            'hammam'      => 'Hammam',

            'tour'        => 'Excursion',

            'walking'     => 'Visite guidée',

            'escape'      => 'Loisir',

            'adventure'   => 'Aventure',

            'rafting'     => 'Rafting',

            'surf'        => 'Surf',

            'beach'       => 'Plage',

            'camp'        => 'Camping',

            'cinema'      => 'Cinéma',

            'theatre'     => 'Théâtre',

            'gallery'     => 'Galerie',

        ];

        foreach (Attraction::all() as $attraction) {

            $name = strtolower($attraction->attraction);

            $type = 'Attraction touristique';

            foreach ($keywords as $keyword => $value) {

                if (str_contains($name, $keyword)) {

                    $type = $value;

                    break;

                }

            }

            $attraction->update([

                'type' => $type

            ]);

            $count++;

        }

        $this->info($count . ' attractions mises à jour.');
    }
}
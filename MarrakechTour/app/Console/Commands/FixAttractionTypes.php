<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attraction;

class FixAttractionTypes extends Command
{
    protected $signature = 'app:fix-attraction-types';

    protected $description = 'Classification intelligente des attractions';

    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | On ne traite QUE les attractions encore non classées
        |--------------------------------------------------------------------------
        */

        $attractions = Attraction::where('type', 'Attraction touristique')->get();

        $count = 0;

        /*
        |--------------------------------------------------------------------------
        | Fonction de normalisation
        |--------------------------------------------------------------------------
        */

        $normalize = function ($text) {

            $text = strtolower($text ?? '');

            $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);

            $text = preg_replace('/[^a-z0-9 ]/', ' ', $text);

            $text = preg_replace('/\s+/', ' ', $text);

            return trim($text);

        };

        /*
        |--------------------------------------------------------------------------
        | Toutes les règles de classification
        |--------------------------------------------------------------------------
        */

        $rules = [
                        /*
            |--------------------------------------------------------------------------
            | Musées
            |--------------------------------------------------------------------------
            */

            'Musée' => [

                'exact' => [

                    'musee de la palmeraie',

                ],

                'tripadvisor' => [

                    'museum',
                    'museums',
                    'history museum',
                    'history museums',
                    'art museum',
                    'art museums',
                    'speciality museum',
                    'speciality museums',

                ],

                'keywords' => [

                    'museum',
                    'musee',
                    'musée',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Jardins
            |--------------------------------------------------------------------------
            */

            'Jardin' => [

                'exact' => [

                    'le jardin du safran',
                    'jardin bio aromatique nectarome',
                    'le paradis du safran'

                ],

                'tripadvisor' => [

                    'garden',
                    'gardens',
                    'botanical garden',
                    'botanical gardens',
                    'park',
                    'parks',

                ],

                'keywords' => [

                    'garden',
                    'gardens',
                    'botanical garden',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Palais
            |--------------------------------------------------------------------------
            */

            'Palais' => [

                'exact' => [

                ],

                'tripadvisor' => [

                    'palace',

                ],

                'keywords' => [

                    'palace',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Mosquées
            |--------------------------------------------------------------------------
            */

            'Mosquée' => [

                'exact' => [

                ],

                'tripadvisor' => [

                    'mosque',
                    'mosques',

                ],

                'keywords' => [

                    'mosque',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Site religieux
            |--------------------------------------------------------------------------
            */

            'Site religieux' => [

                'exact' => [

                ],

                'tripadvisor' => [

                    'religious site',
                    'religious sites',
                    'church',
                    'churches',
                    'cathedral',
                    'cathedrals',
                    'synagogue',
                    'synagogues',
                    'cemetery',
                    'cemeteries',

                ],

                'keywords' => [

                    'church',
                    'cathedral',
                    'synagogue',
                    'cemetery',

                ],

            ],
                        /*
            |--------------------------------------------------------------------------
            | Souks
            |--------------------------------------------------------------------------
            */

            'Souk' => [

                'exact' => [

                ],

                'tripadvisor' => [

                    'flea markets',
                    'street markets',
                    'farmers markets',
                    'food markets',

                ],

                'keywords' => [

                    'souk',
                    'souks',
                    'market',
                    'bazaar',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Monuments
            |--------------------------------------------------------------------------
            */

            'Monument' => [

                'exact' => [

                    'essaouira ramparts',

                ],

                'tripadvisor' => [

                    'points of interest landmarks',
                    'historic walking areas',

                ],

                'keywords' => [

                    'ramparts',
                    'landmark',
                    'monument',
                    'memorial',
                    'fortress',
                    'fort',
                    'tower',
                    'koubba',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Galerie d'art
            |--------------------------------------------------------------------------
            */

            'Galerie d\'art' => [

                'exact' => [

                    'galerie la kasbah',

                ],

                'tripadvisor' => [

                    'art gallery',
                    'art galleries',

                ],

                'keywords' => [

                    'gallery',
                    'galerie',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Plages
            |--------------------------------------------------------------------------
            */

            'Plage' => [

                'exact' => [

                    'plage de sidi kaouki',
                    'essaouira beach',

                ],

                'tripadvisor' => [

                    'beach',
                    'beaches',
                    'beach pool clubs',

                ],

                'keywords' => [

                    'beach',
                    'plage',
                    'coast',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Golf
            |--------------------------------------------------------------------------
            */

            'Golf' => [

                'exact' => [

                    'assoufid golf club',
                    'royal golf marrakech',

                ],

                'tripadvisor' => [

                    'golf course',
                    'golf courses',

                ],

                'keywords' => [

                    'golf',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Lacs
            |--------------------------------------------------------------------------
            */

            'Lac' => [

                'exact' => [

                    'lac lalla takerkoust',

                ],

                'tripadvisor' => [

                    'bodies of water',

                ],

                'keywords' => [

                    'lake',
                    'lac',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Cascades
            |--------------------------------------------------------------------------
            */

            'Cascade' => [

                'exact' => [

                    'setti fatma and the 7 cascades',

                ],

                'tripadvisor' => [

                    'waterfall',
                    'waterfalls',

                ],

                'keywords' => [

                    'cascade',
                    'cascades',
                    'waterfall',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Centre commercial
            |--------------------------------------------------------------------------
            */

            'Centre commercial' => [

                'exact' => [

                    'm avenue marrakech',
                    'menara mall',
                    'almazar centre commercial',

                ],

                'tripadvisor' => [

                    'shopping mall',
                    'shopping malls',

                ],

                'keywords' => [

                    'mall',
                    'shopping',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Parc aquatique
            |--------------------------------------------------------------------------
            */

            'Parc aquatique' => [

                'exact' => [

                    'oasiria',
                    'eden aquapark',
                    'le vizir center',

                ],

                'tripadvisor' => [

                    'water park',
                    'water parks',

                ],

                'keywords' => [

                    'water park',
                    'aquapark',

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | Spa
            |--------------------------------------------------------------------------
            */

            'Spa' => [

                'exact' => [

                ],

                'tripadvisor' => [

                    'spa',

                ],

                'keywords' => [

                    'spa',
                    'massage',
                    'hammam',
                    'wellness',

                ],

            ],

        ];
                /*
        |--------------------------------------------------------------------------
        | Classification
        |--------------------------------------------------------------------------
        */

        foreach ($attractions as $a) {

            $ancienType = $a->type;

            $nom = $normalize($a->attraction);

            $details = $normalize(strip_tags($a->details ?? ''));

            /*
            |--------------------------------------------------------------------------
            | Parcours des règles
            |--------------------------------------------------------------------------
            */

            foreach ($rules as $type => $rule) {

                $matched = false;

                /*
                |--------------------------------------------------------------------------
                | 1. Nom exact (priorité maximale)
                |--------------------------------------------------------------------------
                */

                foreach ($rule['exact'] as $exact) {

                    if ($nom === $normalize($exact)) {

                        $a->type = $type;

                        $matched = true;

                        break;

                    }

                }

                if ($matched) {
                    break;
                }

                /*
                |--------------------------------------------------------------------------
                | 2. Catégories TripAdvisor
                |--------------------------------------------------------------------------
                */

                foreach ($rule['tripadvisor'] as $trip) {

                    if (
                        $details != '' &&
                        str_contains($details, $normalize($trip))
                    ) {

                        $a->type = $type;

                        $matched = true;

                        break;

                    }

                }

                if ($matched) {
                    break;
                }

                /*
                |--------------------------------------------------------------------------
                | 3. Mots-clés (nom + détails)
                |--------------------------------------------------------------------------
                */

                $texte = $nom.' '.$details;

                foreach ($rule['keywords'] as $keyword) {

                    if (str_contains($texte, $normalize($keyword))) {

                        $a->type = $type;

                        $matched = true;

                        break;

                    }

                }

                if ($matched) {
                    break;
                }

            }

            /*
            |--------------------------------------------------------------------------
            | Sauvegarde uniquement si le type a changé
            |--------------------------------------------------------------------------
            */

            if ($a->type != $ancienType) {

                $a->save();

                $count++;

            }

        }
                /*
        |--------------------------------------------------------------------------
        | Résultat
        |--------------------------------------------------------------------------
        */

        $this->newLine();

        $this->info('==========================================');
        $this->info(' Classification terminée avec succès');
        $this->info('==========================================');

        $this->newLine();

        $this->info("✔ {$count} attractions reclassées.");

        return Command::SUCCESS;

    }

}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attraction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImportAttractions extends Command
{
    protected $signature = 'import:attractions';

    protected $description = 'Importer les attractions depuis les fichiers CSV';


    /**
     * Détecter automatiquement le type d'attraction
     */
    private function detectType($details)
    {
        $details = strtolower($details ?? '');

        if (str_contains($details, 'garden') || str_contains($details, 'jardin')) {
            return 'Jardin';
        }

        if (
            str_contains($details, 'palace') ||
            str_contains($details, 'architectural')
        ) {
            return 'Palais';
        }

        if (
            str_contains($details, 'museum') ||
            str_contains($details, 'musée')
        ) {
            return 'Musée';
        }

        if (
            str_contains($details, 'historic') ||
            str_contains($details, 'landmark')
        ) {
            return 'Site historique';
        }

        if (
            str_contains($details, 'waterfall') ||
            str_contains($details, 'cascade')
        ) {
            return 'Cascade';
        }

        if (
            str_contains($details, 'tour') ||
            str_contains($details, 'trip')
        ) {
            return 'Excursion';
        }


        return 'Attraction touristique';
    }



    public function handle()
    {

        $oldCsv = base_path('dataset/attractions_old.csv');
        $newCsv = base_path('dataset/attractions_new.csv');


        if (!File::exists($oldCsv) || !File::exists($newCsv)) {

            $this->error('Un des fichiers CSV est introuvable.');

            return;
        }



        $handle = fopen($oldCsv, 'r');
        $newHandle = fopen($newCsv, 'r');


        if (!$handle || !$newHandle) {

            $this->error('Impossible d ouvrir les fichiers CSV.');

            return;
        }



        // Ignorer les entêtes
        fgetcsv($handle);
        fgetcsv($newHandle);



        /*
        |--------------------------------------------------------------------------
        | Chargement du nouveau CSV
        |--------------------------------------------------------------------------
        */

        $extraData = [];


        while (($newData = fgetcsv($newHandle, 0, ",")) !== false) {


            $nom = trim(
                preg_replace('/^\d+\.\s*/', '', $newData[4])
            );


            $extraData[$nom] = [

                // colonne details
                'details' => $newData[6] ?? null,


                'languages' => $newData[9] ?? null,


                'location_img' => $newData[10] ?? null,


                'ratings_list' => $newData[11] ?? null,

            ];

        }




        $count = 0;



        /*
        |--------------------------------------------------------------------------
        | Import ancien CSV + fusion nouveau CSV
        |--------------------------------------------------------------------------
        */


        while (($data = fgetcsv($handle, 0, ",")) !== false) {


            $rate = is_numeric($data[1]) ? $data[1] : null;


            $attraction = preg_replace(
                '/^\d+\.\s*/',
                '',
                $data[2]
            );


            $reviews = $data[3];


            $attraction_url = $data[5];


            $reviews_url = $data[6];


            $uuid = $data[7];



            // Valeurs par défaut

            $details = null;

            $languages = null;

            $location_img = null;

            $ratings_list = null;

            $type = null;




            /*
             * Chercher les informations dans attractions_new.csv
             */

            if(isset($extraData[$attraction])) {


                $details = $extraData[$attraction]['details'];


                $languages = $extraData[$attraction]['languages'];


                $location_img = $extraData[$attraction]['location_img'];


                $ratings_list = $extraData[$attraction]['ratings_list'];


            }



            // Détection du type

            $type = $this->detectType($details);




            /*
             * Eviter les doublons
             */

            if (Attraction::where('uuid',$uuid)->exists()) {

                continue;

            }




            /*
             * Gestion image
             */

            $photo = null;


            $imagePath = base_path(
                'dataset/images/'.$uuid.'/image_1.jpg'
            );



            if(File::exists($imagePath)) {


                $imageName = $uuid.'.jpg';



                Storage::disk('public')->put(
                    'attractions/'.$imageName,
                    File::get($imagePath)
                );



                $photo = 'attractions/'.$imageName;

            }





            /*
             * Création attraction
             */

            Attraction::create([


                'rate' => $rate,


                'attraction' => $attraction,


                'reviews' => $reviews,


                'details' => $details,


                'attraction_url' => $attraction_url,


                'reviews_url' => $reviews_url,



                'languages' => $languages,


                'location_img' => $location_img,


                'ratings_list' => $ratings_list,


                'type' => $type,



                'latitude' => null,


                'longitude' => null,



                'uuid' => $uuid,


                'photo' => $photo,


            ]);



            $count++;

        }




        fclose($handle);

        fclose($newHandle);



        $this->info(
            $count.' attractions importées avec succès.'
        );

    }

}
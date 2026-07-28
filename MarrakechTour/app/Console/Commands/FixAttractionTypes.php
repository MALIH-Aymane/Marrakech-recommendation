<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attraction;

class FixAttractionTypes extends Command
{
    protected $signature = 'app:fix-attraction-types';

    protected $description = 'Recatégorise automatiquement les attractions touristiques';

    public function handle()
    {
        $attractions = Attraction::where('type', 'Attraction touristique')->get();

        $count = 0;

        foreach ($attractions as $a) {
            $ancienType = $a->type;

            $text = strtolower(
                ($a->attraction ?? '') . ' ' .
                strip_tags($a->details ?? '')
            );

            /*
            |--------------------------------------------------------
            | Jardins
            |--------------------------------------------------------
            */

            if (

                str_contains($text,'garden') ||
                str_contains($text,'gardens') ||
                str_contains($text,'botanical garden') ||
                str_contains($text,'botanical gardens') ||
                str_contains($text,'public garden') ||
                str_contains($text,'rose garden') ||
                str_contains($text,'park') ||
                str_contains($text,'parks') ||
                str_contains($text,'majorelle') ||
                str_contains($text,'cyber parc') ||
                str_contains($text,'menara gardens')

            ) {

                $a->type = 'Jardin';

            }

            /*
            |--------------------------------------------------------
            | Musées
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'museum') ||
                str_contains($text,'museums') ||
                str_contains($text,'history museum') ||
                str_contains($text,'history museums') ||
                str_contains($text,'art museum') ||
                str_contains($text,'art museums') ||
                str_contains($text,'speciality museum') ||
                str_contains($text,'speciality museums') ||
                str_contains($text,'science museum') ||
                str_contains($text,'heritage museum') ||
                str_contains($text,'musée')

            ) {

                $a->type = 'Musée';

            }

            /*
            |--------------------------------------------------------
            | Palais
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'palace') ||
                str_contains($text,'palaces') ||
                str_contains($text,'royal palace') ||
                str_contains($text,'architectural building') ||
                str_contains($text,'architectural buildings') ||
                str_contains($text,'bahia palace') ||
                str_contains($text,'el badi')

            ) {

                $a->type = 'Palais';

            }

            /*
            |--------------------------------------------------------
            | Sites historiques
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'historic site') ||
                str_contains($text,'historic sites') ||
                str_contains($text,'historical site') ||
                str_contains($text,'historical sites') ||
                str_contains($text,'heritage site') ||
                str_contains($text,'unesco') ||
                str_contains($text,'historic walking areas')

            ) {

                $a->type = 'Site historique';

            }

            /*
            |--------------------------------------------------------
            | Spa
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'spa') ||
                str_contains($text,'spas') ||
                str_contains($text,'massage') ||
                str_contains($text,'wellness') ||
                str_contains($text,'hammam') ||
                str_contains($text,'turkish bath') ||
                str_contains($text,'arab bath')

            ) {

                $a->type = 'Spa';

            }
                        /*
            |--------------------------------------------------------
            | Mosquées
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'mosque') ||
                str_contains($text,'mosques') ||
                str_contains($text,'koutoubia') ||
                str_contains($text,'kasbah mosque')

            ) {

                $a->type = 'Mosquée';

            }

            /*
            |--------------------------------------------------------
            | Souks et marchés
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'souk') ||
                str_contains($text,'souks') ||
                str_contains($text,'market') ||
                str_contains($text,'markets') ||
                str_contains($text,'flea & street markets') ||
                str_contains($text,'farmers markets') ||
                str_contains($text,'bazaar')

            ) {

                $a->type = 'Souk';

            }

            /*
            |--------------------------------------------------------
            | Places
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'square') ||
                str_contains($text,'plaza') ||
                str_contains($text,'place des') ||
                str_contains($text,'jemaa el-fnaa') ||
                str_contains($text,'rahba kedima')

            ) {

                $a->type = 'Place';

            }

            /*
            |--------------------------------------------------------
            | Monuments
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'monument') ||
                str_contains($text,'monuments') ||
                str_contains($text,'landmark') ||
                str_contains($text,'landmarks') ||
                str_contains($text,'memorial') ||
                str_contains($text,'koubba') ||
                str_contains($text,'ramparts')

            ) {

                $a->type = 'Monument';

            }

            /*
            |--------------------------------------------------------
            | Galeries d'art
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'gallery') ||
                str_contains($text,'galleries') ||
                str_contains($text,'art gallery') ||
                str_contains($text,'art galleries')

            ) {

                $a->type = 'Galerie d\'art';

            }

            /*
            |--------------------------------------------------------
            | Ruines
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'archaeological') ||
                str_contains($text,'ancient ruins') ||
                str_contains($text,'ruins')

            ) {

                $a->type = 'Ruines';

            }

            /*
            |--------------------------------------------------------
            | Lacs
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'lake') ||
                str_contains($text,'lac') ||
                str_contains($text,'bodies of water')

            ) {

                $a->type = 'Lac';

            }

            /*
            |--------------------------------------------------------
            | Cascades
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'waterfall') ||
                str_contains($text,'waterfalls') ||
                str_contains($text,'cascade') ||
                str_contains($text,'cascades')

            ) {

                $a->type = 'Cascade';

            }

            /*
            |--------------------------------------------------------
            | Golf
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'golf') ||
                str_contains($text,'golf course') ||
                str_contains($text,'golf courses')

            ) {

                $a->type = 'Golf';

            }

            /*
            |--------------------------------------------------------
            | Centres commerciaux
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'shopping mall') ||
                str_contains($text,'shopping malls') ||
                str_contains($text,'shopping center') ||
                str_contains($text,'shopping centre') ||
                str_contains($text,'centre commercial') ||
                str_contains($text,'mall')

            ) {

                $a->type = 'Centre commercial';

            }
                        /*
            |--------------------------------------------------------
            | Plages
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'beach') ||
                str_contains($text,'beaches') ||
                str_contains($text,'beach club') ||
                str_contains($text,'beach & pool clubs') ||
                str_contains($text,'coast') ||
                str_contains($text,'seaside')

            ) {

                $a->type = 'Plage';

            }

            /*
            |--------------------------------------------------------
            | Parcs aquatiques
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'water park') ||
                str_contains($text,'water parks') ||
                str_contains($text,'aquapark') ||
                str_contains($text,'aquatic park')

            ) {

                $a->type = 'Parc aquatique';

            }

            /*
            |--------------------------------------------------------
            | Sites religieux
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'religious site') ||
                str_contains($text,'religious sites') ||
                str_contains($text,'church') ||
                str_contains($text,'churches') ||
                str_contains($text,'cathedral') ||
                str_contains($text,'cathedrals') ||
                str_contains($text,'synagogue') ||
                str_contains($text,'cemetery') ||
                str_contains($text,'cemeteries')

            ) {

                $a->type = 'Site religieux';

            }

            /*
            |--------------------------------------------------------
            | Ports
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'fishing port') ||
                str_contains($text,'harbour') ||
                str_contains($text,'harbor') ||
                str_contains($text,'port')

            ) {

                $a->type = 'Monument';

            }

            /*
            |--------------------------------------------------------
            | Activités : on laisse Attraction touristique
            |--------------------------------------------------------
            */

            elseif (

                str_contains($text,'tour') ||
                str_contains($text,'tours') ||
                str_contains($text,'guided tour') ||
                str_contains($text,'private tour') ||
                str_contains($text,'walking tour') ||
                str_contains($text,'bike tour') ||
                str_contains($text,'food tour') ||
                str_contains($text,'shopping tour') ||
                str_contains($text,'camel') ||
                str_contains($text,'camel ride') ||
                str_contains($text,'quad') ||
                str_contains($text,'buggy') ||
                str_contains($text,'atv') ||
                str_contains($text,'4wd') ||
                str_contains($text,'balloon') ||
                str_contains($text,'hot air balloon') ||
                str_contains($text,'adventure') ||
                str_contains($text,'travel') ||
                str_contains($text,'trek') ||
                str_contains($text,'trekking') ||
                str_contains($text,'hiking') ||
                str_contains($text,'excursion') ||
                str_contains($text,'taxi') ||
                str_contains($text,'shuttle') ||
                str_contains($text,'transport') ||
                str_contains($text,'transfer') ||
                str_contains($text,'festival') ||
                str_contains($text,'casino') ||
                str_contains($text,'kart') ||
                str_contains($text,'racing')

            ) {

                $a->type = 'Attraction touristique';

            }

            if ($a->type != $ancienType) {

                $a->save();

                $count++;

            }
                    }

        $this->info("✔ {$count} attractions ont été reclassées avec succès.");

        return Command::SUCCESS;
    }
}
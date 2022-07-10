<?php

namespace App\DataFixtures\Asset;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Asset\AssetCategory;

class AssetCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $items = [
            'Climatizzazione' => [
                'Condizionatori',
                'Condizionatori senza unità esterna',
                'Ventilconvettori fan coil',
                'Ventilazione meccanica controllata',
                'Aspiratori',
                'Pompe di calore',
                'Condizionatori portatili',
                'Barriere d\'aria',
                'Deumidificatore0',
                'Purificatore d\'aria'
            ],
            'Riscaldamento' => [
                'Caldaie',
                'Stufe',
                'Termoconvettori a gas',
                'Termoarredo',
                'Termocamini',
                'Sistema ibrido',
                'Scaldabagno',
                'Termosifoni',
                'Termocucine'
            ],
            'Idraulica' => [
                'Elettropompe',
                'Rubinetti',
                'Colonne doccia',
                'Saliscendi',
                'Sanitari',
                'Accessori bagno',
                'Cassette WC e placche',
                'Trituratore WC',
                'Sanificazione ambiente'
            ],
            'Energia rinnovabile' => [
                'Colonnine ricarica auto elettriche',
                'Pannelli solari',
                'Docce solari'
            ],
            'Accessori' => [
                'Accessori termocamini',
                'Accessori stufe a biomassa',
                'Accessori elettropompe',
                'Accessori stufe a gas',
                'Accessori caldaia',
                'Accessori condizionatori',
                'Accessori solare termico',
                'Accessori pompe di calore',
                'Accessori per termosifoni',
                'Accessori ventilconvettori',
                'Accessori per scaldabagni',
                'Accessori sanitari'
            ],
        ];

        foreach ($items as $key => $item) {
            $category = new AssetCategory();
            $category->setName($key);
            $category->setSlug($key);
            $category->setActive(true);
            $manager->persist($category);
            
        }

        $manager->flush();
    }
}

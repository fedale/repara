<?php

namespace App\DataFixtures\Asset;

use App\Entity\Asset\AssetType;
use App\Factory\Asset\AssetTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssetTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getAssetTypes() as $typeName) {
            $assetType = new AssetType();
            $assetType->setName($typeName);
            $manager->persist($assetType);
        }

        $manager->flush();
    }

    private function getAssetTypes()
    {
        return [
            // Fonte: climarket.it
            // Forse meglio chiamarle "categorie" e implementare sotto categorie
            // Climatizzazione
            'Condizionatori',
            'Condizionatori senza unità esterna',
            'Ventilconvettori fan coil',
            'Ventilazione meccanica controllata',
            'Aspiratori',
            'Pompe di calore',
            'Condizionatori portatili',
            'Barriere d\'aria',
            'Deumidificatore',
            'Purificatore d\'aria',
            // Riscaldamento
            'Caldaie',
            'Stude',
            'Termoconvettori a gas',
            'Termoarredo',
            'Termocamini',
            'Sistema ibrido',
            'Scaldabagno',
            'Termosifoni',
            'Termocucine',
            // Idraulica
            'Elettropompe',
            'Rubinetti',
            'Colonne doccia',
            'Saliscendi',
            'Sanitari',
            'Accessori bagno',
            'Cassette WC e placce',
            'Trituratore WC',
            'Sanificazione ambiente',
            // Energia rinnovabile
            'Colonnine ricarica auto elettriche',
            'Pannelli solari',
            'Docce solari',
            // Accessori
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
        ];
    }
}

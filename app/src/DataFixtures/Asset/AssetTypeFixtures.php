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
        // https://corporatefinanceinstitute.com/resources/knowledge/accounting/types-of-assets/
        $assetTypes = [
            'Condizionatori',
            'Caldaie',
            'Termosifoni',
            'Altro'
        ];

        foreach ($assetTypes as $type) {
            $assetType = new AssetType();
            $assetType->setName($type);
            $manager->persist($assetType);

        }

        AssetTypeFactory::createMany(10);

        $manager->flush();
    }
}

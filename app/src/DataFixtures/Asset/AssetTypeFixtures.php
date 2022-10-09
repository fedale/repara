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
        foreach (range(1, 10) as $type) {
            $assetType = new AssetType();
            $assetType->setName('Type ' . $type);
            $assetType->setSlug('type-' . $type);
            $manager->persist($assetType);
        }

        $manager->flush();
    }
}

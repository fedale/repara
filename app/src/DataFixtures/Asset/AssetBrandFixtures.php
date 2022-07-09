<?php

namespace App\DataFixtures\Asset;

use App\Factory\Asset\AssetBrandFactory;
use App\Factory\Asset\AssetTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssetBrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AssetBrandFactory::createMany(\rand(10, 100));

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AssetTypeFixtures::class,
        ];
    }
}

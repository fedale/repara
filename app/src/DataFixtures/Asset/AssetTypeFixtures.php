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
        return;
    }

  
}

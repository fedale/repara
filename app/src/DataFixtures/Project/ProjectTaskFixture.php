<?php

namespace App\DataFixtures\Project;

use App\DataFixtures\Customer\CustomerLocationPlaceAssetFixtures;
use App\DataFixtures\Customer\CustomerTypeFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerTypeFixtures::class,
            ProjectTaskTypeFixture::class,
            CustomerLocationPlaceAssetFixtures::class,
        ];
    }
}

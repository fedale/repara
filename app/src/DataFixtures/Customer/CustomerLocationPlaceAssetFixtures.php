<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\CustomerLocationPlace;
use App\Factory\Customer\CustomerLocationPlaceAssetFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerLocationPlaceAssetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customerLocationPlaces = $manager->getRepository(CustomerLocationPlace::class)->findAll();

        foreach ($customerLocationPlaces as $customerLocationPlace) {
            CustomerLocationPlaceAssetFactory::createMany(\rand(1, 15), function () use ($customerLocationPlace) {
                return [
                    'place' => null,
                    'asset' => null
                ];
            });
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CustomerLocationPlaceFixtures::class,
            // AssetFix
        ];
    }
}

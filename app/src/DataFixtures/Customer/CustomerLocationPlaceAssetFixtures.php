<?php

namespace App\DataFixtures\Customer;

use App\DataFixtures\Asset\AssetFixtures;
use App\Entity\Asset\Asset;
use App\Entity\Customer\CustomerLocationPlace;
use App\Entity\Customer\CustomerLocationPlaceAsset;
use App\Factory\Customer\CustomerLocationPlaceAssetFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerLocationPlaceAssetFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        return;
        $customerLocationPlaces = $manager->getRepository(CustomerLocationPlace::class)->findAll();
        $assets = $manager->getRepository(Asset::class)->findAll();

        foreach (range(1, 1000) as $item) {
            $customerLocationPlaceAsset = new CustomerLocationPlaceAsset();
            $customerLocationPlaceAsset->setName('Customer Location Place Asset ' . $item);
            $customerLocationPlaceAsset->setCode('code-' . $item);
            $customerLocationPlaceAsset->setCustomerLocationPlace($customerLocationPlaces[array_rand($customerLocationPlaces)]);
            $customerLocationPlaceAsset->setAsset($assets[array_rand($assets)]);
            $manager->persist($customerLocationPlaceAsset);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CustomerLocationPlaceFixtures::class,
            AssetFixtures::class,
        ];
    }
}

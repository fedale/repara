<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocation;
use App\Factory\Customer\CustomerFactory;
use App\Factory\Customer\CustomerLocationFactory;
use App\Factory\Customer\CustomerLocationPlaceFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerLocationPlaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $customerLocations = $manager->getRepository(CustomerLocation::class)->findAll();

        foreach ($customerLocations as $customerLocation) {
            CustomerLocationPlaceFactory::createMany(\rand(1,5), function () use ($customerLocation) {
                return [
                    'location' => $customerLocation,
                ];
            });
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CustomerLocationFixtures::class,
        ];
    }
}

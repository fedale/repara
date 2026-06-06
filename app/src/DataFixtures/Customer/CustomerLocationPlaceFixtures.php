<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\CustomerLocation;
use App\Entity\Customer\CustomerLocationPlace;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerLocationPlaceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $customerLocations = $manager->getRepository(CustomerLocation::class)->findAll();
        $batchSize = 1000;
        $created = 0;

        foreach ($customerLocations as $customerLocation) {
            foreach (range(1, \rand(1, 5)) as $item) {
                $place = new CustomerLocationPlace();
                $place->setCustomerLocation($customerLocation);
                $place->setName(\substr($faker->word() . ' ' . $faker->randomNumber(3), 0, 64));
                $place->setActive($faker->boolean());

                $manager->persist($place);

                if (++$created % $batchSize === 0) {
                    $manager->flush();
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerLocationFixtures::class,
        ];
    }
}

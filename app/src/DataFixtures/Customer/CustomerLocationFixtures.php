<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CustomerLocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $customers = $manager->getRepository(Customer::class)->findAll();
        $batchSize = 500;
        $created = 0;

        foreach ($customers as $customer) {
            foreach (range(1, \rand(1, 5)) as $item) {
                $location = new CustomerLocation();
                $location->setCustomer($customer);
                $location->setName(\substr($faker->company(), 0, 128));
                $location->setAddress(\substr($faker->streetAddress(), 0, 64));
                $location->setZipcode($faker->bothify('#####'));
                $location->setCity(\substr($faker->city(), 0, 64));
                $location->setCountry(\substr($faker->country(), 0, 32));
                $location->setActive($faker->boolean());

                $manager->persist($location);

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
            CustomerFixtures::class,
        ];
    }
}

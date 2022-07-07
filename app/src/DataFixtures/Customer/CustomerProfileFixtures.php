<?php

namespace App\DataFixtures\Customer;

use App\Factory\Customer\CustomerFactory;
use App\Factory\Customer\CustomerProfileFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerProfileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        return;
        CustomerProfileFactory::createMany(10, function () {
            return [
                'customer' => CustomerFactory::createOne()
            ];
        });
        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
        ];
    }
}

<?php

namespace App\DataFixtures\Customer;

use App\Factory\Customer\CustomerFactory;
use App\Factory\Customer\CustomerLocationFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerLocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        return;
        CustomerLocationFactory::createMany(5, function () {
            return [
                'customer' => CustomerFactory::random(),
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

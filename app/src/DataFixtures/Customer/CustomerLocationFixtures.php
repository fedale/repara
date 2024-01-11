<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\Customer;
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
        $customers = $manager->getRepository(Customer::class)->findAll();

        foreach ($customers as $customer) {
            CustomerLocationFactory::createMany(\rand(1,5), function () use ($customer) {
                return [
                    'customer' => $customer,
                ];
            });
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CustomerFixtures::class,
        ];
    }
}

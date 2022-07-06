<?php

namespace App\DataFixtures;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerProfile;
use App\Entity\Customer\CustomerType;
use App\Factory\Customer\CustomerFactory;
use App\Factory\Customer\CustomerProfileFactory;
use App\Factory\Customer\CustomerTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $customerTypes = $manager->getRepository(CustomerType::class)->findAll();
        
        CustomerFactory::createMany(10, function () use ($customerTypes) {
            return [
                'type' => $customerTypes[array_rand($customerTypes)]
            ];
        });
        

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerTypeFixtures::class,
        ];
    }
}

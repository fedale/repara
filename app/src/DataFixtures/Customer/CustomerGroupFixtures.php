<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\CustomerGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customerGroup1 = new CustomerGroup();
        $customerGroup1->setName('Agenti');
        $manager->persist($customerGroup1);

        $customerGroup2 = new CustomerGroup();
        $customerGroup2->setName('Commercial');
        $manager->persist($customerGroup2);
        
        $customerGroup3 = new CustomerGroup();
        $customerGroup3->setName('Marketing');
        $manager->persist($customerGroup3);

        $customerGroup4 = new CustomerGroup();
        $customerGroup4->setName('Clienti russi');
        $manager->persist($customerGroup3);

        $customerGroup5 = new CustomerGroup();
        $customerGroup5->setName('Gruppo calcetto');
        $manager->persist($customerGroup4);

        $customerGroup6 = new CustomerGroup();
        $customerGroup6->setName('Amici di tavolata');
        $manager->persist($customerGroup5);

        $customerGroup7 = new CustomerGroup();
        $customerGroup7->setName('Test');
        $manager->persist($customerGroup7);

        $manager->flush();
    }
}

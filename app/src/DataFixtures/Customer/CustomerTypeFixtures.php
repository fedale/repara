<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\CustomerType;
use App\Factory\Customer\CustomerTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $customerType1 = new CustomerType();
        $customerType1->setName('Privato');
        $manager->persist($customerType1);

        $customerType2 = new CustomerType();
        $customerType2->setName('Azienda');
        $manager->persist($customerType2);

        $manager->flush();
    }
}

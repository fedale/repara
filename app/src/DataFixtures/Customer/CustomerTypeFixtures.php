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
        foreach ($this->getTypes() as $type) {
            $customerType = new CustomerType();
            $customerType->setName($type);
            $manager->persist($customerType);
        }

        $manager->flush();
    }

    private function getTypes(): array
    {
        return [
            'Privato',
            'Azienda'
        ];
    }
}

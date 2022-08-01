<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\CustomerGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getGroups() as $group) {
            $customerGroup = new CustomerGroup();
            $customerGroup->setName($group);
            $manager->persist($customerGroup);
        }

        $manager->flush();
    }

    private function getGroups(): array 
    {
        return [
            'Agents',
            'Commercials',
            'Marketing',
            'Clienti russi',
            'Gruppo calcetto',
            'Amici di tavoltata',
            'Test'
        ];
    }
}

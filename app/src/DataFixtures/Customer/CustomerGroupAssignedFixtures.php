<?php

namespace App\DataFixtures\Customer;

use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CustomerGroupAssignedFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $customers = $manager->getRepository(Customer::class)->findAll();
        $repository = $manager->getRepository(CustomerGroup::class);
        
        // $repository = $customerGroups = $manager->getRepository(CustomerGroup::class)->findBy([], [], \rand(1, 10) );

        foreach ($customers as $customer) {
            $customerGroups = $repository->createQueryBuilder('cg')
              //  ->orderBy('RAND()')
                ->setMaxResults( \rand(1, 10) )
                ->getQuery()
                ->getResult()
            ;

            foreach ($customerGroups as $customerGroup) {
                $customer->addGroup($customerGroup);
                $manager->persist($customer);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CustomerGroupFixtures::class,
            CustomerFixtures::class
        ];
    }
}

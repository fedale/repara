<?php

namespace App\DataFixtures;

use App\Entity\Customer\CustomerProfile;
use App\Factory\Customer\CustomerFactory;
use App\Factory\Customer\CustomerProfileFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
          CustomerFactory::new()->many(2)->create();
        /*
        CustomerFactory::createMany(5, function () {
            return [
                'profile' => CustomerProfileFactory::new(),
            ];
        });
        */

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures\User;

use App\Entity\User\UserType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Type 1', 'Type 2', 'Type 3', 'Type 4'];
        foreach ($types as $type) {
            $entity = new UserType();
            $entity->setName($type);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}

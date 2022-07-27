<?php

namespace App\DataFixtures\User;

use App\Entity\User\UserGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserGroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $groups = ['Group 1', 'Group 2', 'Group 3', 'Group 4', 'Group 5'];
        foreach ($groups as $group) {
            $entity = new UserGroup();
            $entity->setName($group);
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
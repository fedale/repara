<?php

namespace App\DataFixtures\User;

use App\Entity\User\UserGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GroupFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $group1 = new UserGroup();
        $group1->setName('Gruppo 1');
        $group1->setCode('gruppo-1');
        $manager->persist($group1);

        $group2 = new UserGroup();
        $group2->setName('Gruppo 2');
        $group2->setCode('gruppo-2');
        $manager->persist($group2);

        $group3 = new UserGroup();
        $group3->setName('Gruppo 3');
        $group3->setCode('gruppo-3');
        $manager->persist($group3);

        $manager->flush();
    }
}
<?php

namespace App\DataFixtures\Project;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskTemplate extends Fixture
{
    public function load(ObjectManager $manager): void
    {
                

        $manager->flush();
    }

}

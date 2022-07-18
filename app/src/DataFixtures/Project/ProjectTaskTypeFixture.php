<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\Task\ProjectTaskType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskTypeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = [
            'Manutenzione ordinaria',
            'Manutenzione straordinaria',
            'Riparazione'
        ];

        foreach ( $types as $type) {
            $item = new ProjectTaskType();
            $item->setName($type);
            $manager->persist($item);
        }
        
        $manager->flush();
    }
}

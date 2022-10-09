<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\Task\ProjectTaskType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskTypeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ( $this->getTypes() as $type ) {
            $item = new ProjectTaskType();
            $item->setName($type);
            $manager->persist($item);
        }
        
        $manager->flush();
    }

    private function getTypes(): array
    {
        return [
            'Ordinary maintenance',
            'Extraordinary maintenance',
            'Repair'
        ];
    }
}

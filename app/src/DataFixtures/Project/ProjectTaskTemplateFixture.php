<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\TaskTemplate\ProjectTaskTemplate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskTemplateFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getProjectTaskTemplates() as $k => $projectTaskTemplate)
        {
            $item = new ProjectTaskTemplate(); 
            $item->setName($projectTaskTemplate['name']);
            $item->setDescription($projectTaskTemplate['description']);
            $item->setActive($projectTaskTemplate['active']);
            $manager->persist($item);
        }

        $manager->flush();
    }

    private function getProjectTaskTemplates(): array
    {
        return [
            [
                'name' => 'Project task template 1',
                'description' => 'This is a description of project task template #1',
                'active' => 1
            ],
            [
                'name' => 'Project task template 2',
                'description' => 'This is a description of project task template #2',
                'active' => 1
            ],
            [
                'name' => 'Project task template 3',
                'description' => 'This is a description of project task template #3',
                'active' => 1
            ],
            [
                'name' => 'Project task template 4',
                'description' => 'This is a description of project task template #4',
                'active' => 1
            ],
            [
                'name' => 'Project task template 5',
                'description' => 'This is a description of project task template #5',
                'active' => 1
            ],
            [
                'name' => 'Project task template 5',
                'description' => 'This is a description of project task template #5',
                'active' => 1
            ],
            [
                'name' => 'Project task template 7',
                'description' => 'This is a description of project task template #7',
                'active' => 1
            ],
        ];
    }

}

<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\Task\ProjectTaskType;
use App\Entity\Project\TaskTemplate\ProjectTaskItemTemplate;
use App\Entity\Project\TaskTemplate\ProjectTaskTemplate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskItemTemplateFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $projectTaskTemplates = $manager->getRepository(ProjectTaskTemplate::class)->findAll();
        $projectTaskType = $manager->getRepository(ProjectTaskType::class)->findOneBy(['name' => 'Riparazione']);

        $c = 1;
        foreach ($projectTaskTemplates as $projectTaskTemplate) {
            $randomItems = \rand(3, 15);
            for($i=0; $i < $randomItems; ++$i) {
                $projectTaskItemTemplate = new ProjectTaskItemTemplate();
                $projectTaskItemTemplate->setName('Project Task Item #' . $c);
                $projectTaskItemTemplate->setTaskTemplate($projectTaskTemplate);
                $projectTaskItemTemplate->setTaskType($projectTaskType);
                $projectTaskItemTemplate->setSort(\rand(1, 99));
                $manager->persist($projectTaskItemTemplate);
                $c++;
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectTaskTemplateFixture::class,
            ProjectTaskTypeFixture::class,
        ];
    }

}

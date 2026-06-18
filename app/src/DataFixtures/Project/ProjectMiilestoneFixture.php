<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\Project;
use App\Entity\Project\ProjectMilestone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectMiilestoneFixture extends Fixture implements DependentFixtureInterface
{
    private const MIN_MILESTONES_PER_PROJECT = 2;
    private const MAX_MILESTONES_PER_PROJECT = 5;

    public function load(ObjectManager $manager): void
    {
        $projects = $manager->getRepository(Project::class)->findAll();

        foreach ($projects as $project) {
            $milestoneCount = \rand(self::MIN_MILESTONES_PER_PROJECT, self::MAX_MILESTONES_PER_PROJECT);
            for ($i = 1; $i <= $milestoneCount; ++$i) {
                $milestone = new ProjectMilestone();
                $milestone->setName($project->getCode() . ' - Milestone #' . $i);
                $milestone->setProject($project);
                $milestone->setExpirationDate(
                    (new \DateTime())->modify('+' . \rand(7, 365) . ' days')
                );
                $milestone->setActive(true);
                $manager->persist($milestone);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectFixture::class,
        ];
    }
}

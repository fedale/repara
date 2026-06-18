<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\ProjectMilestone;
use App\Entity\Project\Task\ProjectTask;
use App\Entity\Project\Task\ProjectTaskMilestone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskMilestoneFixture extends Fixture implements DependentFixtureInterface
{
    private const MIN_MILESTONES_PER_TASK = 1;
    private const MAX_MILESTONES_PER_TASK = 3;
    private const BATCH_SIZE = 500;

    public function load(ObjectManager $manager): void
    {
        // Milestone raggruppate per progetto: una task può essere collegata solo
        // a milestone dello stesso progetto.
        $milestonesByProject = [];
        foreach ($manager->getRepository(ProjectMilestone::class)->findAll() as $milestone) {
            $milestonesByProject[$milestone->getProject()->getId()][] = $milestone;
        }

        $tasks = $manager->getRepository(ProjectTask::class)->findAll();

        $counter = 0;
        foreach ($tasks as $task) {
            $projectId = $task->getProject()?->getId();
            $available = $milestonesByProject[$projectId] ?? [];
            if ([] === $available) {
                continue;
            }

            $wanted = \min(\rand(self::MIN_MILESTONES_PER_TASK, self::MAX_MILESTONES_PER_TASK), \count($available));
            $keys = (array) \array_rand($available, $wanted);

            foreach ($keys as $key) {
                $projectTaskMilestone = new ProjectTaskMilestone();
                $projectTaskMilestone->setProjectTask($task);
                $projectTaskMilestone->setMilestone($available[$key]);
                $projectTaskMilestone->setActive(true);
                $manager->persist($projectTaskMilestone);

                if ((++$counter % self::BATCH_SIZE) === 0) {
                    $manager->flush();
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProjectTaskFixture::class,
            ProjectMiilestoneFixture::class,
        ];
    }
}

<?php

namespace App\DataFixtures\Project;

use App\Entity\Project\Task\ProjectTask;
use App\Entity\Project\TaskItem\ProjectTaskItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProjectTaskItemFixture extends Fixture implements DependentFixtureInterface
{
    private const MIN_ITEMS_PER_TASK = 15;
    private const MAX_ITEMS_PER_TASK = 25;
    private const BATCH_SIZE = 100;

    public function load(ObjectManager $manager): void
    {
        // Carico solo gli id per poter fare flush+clear a blocchi senza
        // detach delle entità ProjectTask referenziate.
        $taskIds = \array_map(
            static fn (ProjectTask $task): int => $task->getId(),
            $manager->getRepository(ProjectTask::class)->findAll()
        );

        $values = ['A', 'B', 'C', 'D', 'E'];
        $c = 1;
        foreach ($taskIds as $k => $taskId) {
            $projectTask = $manager->getReference(ProjectTask::class, $taskId);
            $itemCount = \rand(self::MIN_ITEMS_PER_TASK, self::MAX_ITEMS_PER_TASK);
            for ($i = 0; $i < $itemCount; ++$i) {
                $item = new ProjectTaskItem();
                $item->setName('Project Task Item #' . $c);
                $item->setDescription('Description of project task item #' . $c);
                $item->setProjectTask($projectTask);
                $item->setDifficulty(\rand(0, 5));
                $item->setValue($values[\array_rand($values)]);
                $item->setActive(true);
                $manager->persist($item);
                ++$c;
            }

            if ((($k + 1) % self::BATCH_SIZE) === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [
            ProjectTaskFixture::class,
        ];
    }
}

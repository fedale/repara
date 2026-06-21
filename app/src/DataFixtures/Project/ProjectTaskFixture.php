<?php

namespace App\DataFixtures\Project;

use App\DataFixtures\Customer\CustomerFixtures;
use App\DataFixtures\Customer\CustomerLocationPlaceAssetFixtures;
use App\DataFixtures\Domain\DomainProfileProvider;
use App\DBAL\Types\ProjectTaskPriorityType;
use App\DBAL\Types\ProjectTaskStateType;
use App\Entity\Customer\Customer;
use App\Entity\Customer\CustomerLocationPlaceAsset;
use App\Entity\Project\Project;
use App\Entity\Project\Task\ProjectTask;
use App\Entity\Project\Task\ProjectTaskType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProjectTaskFixture extends Fixture implements DependentFixtureInterface
{
    private const MIN_TASKS_PER_PROJECT = 30;
    private const MAX_TASKS_PER_PROJECT = 70;
    private const BATCH_SIZE = 500;

    public function __construct(private readonly DomainProfileProvider $domains)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $domain = $this->domains->get();

        $actions = $domain->taskActions();
        $subjects = $domain->taskSubjects();

        $projects = $manager->getRepository(Project::class)->findAll();
        $taskTypes = $manager->getRepository(ProjectTaskType::class)->findAll();
        $customers = $manager->getRepository(Customer::class)->findAll();
        $assets = $manager->getRepository(CustomerLocationPlaceAsset::class)->findAll();

        $states = ProjectTaskStateType::TYPES;
        $priorities = ProjectTaskPriorityType::TYPES;

        $counter = 0;
        $c = 1;
        foreach ($projects as $project) {
            $taskCount = \rand(self::MIN_TASKS_PER_PROJECT, self::MAX_TASKS_PER_PROJECT);
            for ($i = 0; $i < $taskCount; ++$i) {
                $action = $actions[\array_rand($actions)];
                $subject = $subjects[\array_rand($subjects)];

                $task = new ProjectTask();
                $task->setName(\sprintf('%s %s', $action, $subject));
                $task->setDescription($faker->sentence(10));
                $task->setProject($project);
                $task->setType($taskTypes[\array_rand($taskTypes)]);
                $task->setState($states[\array_rand($states)]);
                $task->setPriority($priorities[\array_rand($priorities)]);
                $task->setCustomer($customers[\array_rand($customers)]);
                $task->setCustomerLocationPlaceAsset($assets[\array_rand($assets)]);
                $task->setActive(true);
                $task->setVisible(true);
                $manager->persist($task);

                ++$c;
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
            ProjectFixture::class,
            ProjectTaskTypeFixture::class,
            CustomerFixtures::class,
            CustomerLocationPlaceAssetFixtures::class,
        ];
    }
}

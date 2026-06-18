<?php

namespace App\DataFixtures\Project;

use App\DBAL\Types\ProjectTaskStateType;
use App\Entity\Project\Project;
use App\Entity\Project\ProjectType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProjectFixture extends Fixture
{
    private const PROJECT_COUNT = 30;

    public function load(ObjectManager $manager): void
    {
        $types = [];
        foreach ($this->getProjectTypes() as $typeName) {
            $type = new ProjectType();
            $type->setName($typeName);
            $manager->persist($type);
            $types[] = $type;
        }

        $statuses = ProjectTaskStateType::TYPES;
        $colors = ['0d6efd', '6610f2', 'd63384', 'dc3545', 'fd7e14', '198754', '20c997', '0dcaf0'];

        for ($i = 1; $i <= self::PROJECT_COUNT; ++$i) {
            $start = (new \DateTime())->modify('-' . \rand(0, 365) . ' days');
            $end = (clone $start)->modify('+' . \rand(30, 365) . ' days');

            $project = new Project();
            $project->setCode(\sprintf('PRJ-%04d', $i));
            $project->setName('Project #' . $i);
            $project->setDescription('This is the description of project #' . $i);
            $project->setType($types[\array_rand($types)]);
            $project->setStatus($statuses[\array_rand($statuses)]);
            $project->setPriority(\rand(0, 3));
            $project->setBudget((string) \rand(1000, 500000));
            $project->setColor($colors[\array_rand($colors)]);
            $project->setDatetimeStart($start);
            $project->setDatetimeEnd($end);
            $project->setActive(true);
            $project->setVisible(true);

            $manager->persist($project);
        }

        $manager->flush();
    }

    private function getProjectTypes(): array
    {
        return [
            'Internal',
            'Maintenance',
            'Installation',
            'Consulting',
        ];
    }
}

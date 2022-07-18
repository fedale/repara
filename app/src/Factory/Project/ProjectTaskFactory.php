<?php

namespace App\Factory\Project;

use App\Entity\Project\Task\ProjectTask;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<ProjectTask>
 *
 * @method static ProjectTask|Proxy createOne(array $attributes = [])
 * @method static ProjectTask[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ProjectTask|Proxy find(object|array|mixed $criteria)
 * @method static ProjectTask|Proxy findOrCreate(array $attributes)
 * @method static ProjectTask|Proxy first(string $sortedField = 'id')
 * @method static ProjectTask|Proxy last(string $sortedField = 'id')
 * @method static ProjectTask|Proxy random(array $attributes = [])
 * @method static ProjectTask|Proxy randomOrCreate(array $attributes = [])
 * @method static ProjectTask[]|Proxy[] all()
 * @method static ProjectTask[]|Proxy[] findBy(array $attributes)
 * @method static ProjectTask[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static ProjectTask[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method ProjectTask|Proxy create(array|callable $attributes = [])
 */
final class ProjectTaskFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(),
            'status' => self::faker()->text(),
            'assetType' => self::faker()->text(),
            'priority' => self::faker()->numberBetween(1, 32767),
            'visible' => self::faker()->boolean(),
            'active' => self::faker()->boolean(50),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 year'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(ProjectTask $projectTask): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ProjectTask::class;
    }
}

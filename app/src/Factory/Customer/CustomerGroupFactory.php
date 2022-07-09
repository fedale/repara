<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerGroup;
use App\Repository\Customer\CustomerGroupRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerGroup>
 *
 * @method static CustomerGroup|Proxy createOne(array $attributes = [])
 * @method static CustomerGroup[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerGroup|Proxy find(object|array|mixed $criteria)
 * @method static CustomerGroup|Proxy findOrCreate(array $attributes)
 * @method static CustomerGroup|Proxy first(string $sortedField = 'id')
 * @method static CustomerGroup|Proxy last(string $sortedField = 'id')
 * @method static CustomerGroup|Proxy random(array $attributes = [])
 * @method static CustomerGroup|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerGroup[]|Proxy[] all()
 * @method static CustomerGroup[]|Proxy[] findBy(array $attributes)
 * @method static CustomerGroup[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerGroup[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CustomerGroupRepository|RepositoryProxy repository()
 * @method CustomerGroup|Proxy create(array|callable $attributes = [])
 */
final class CustomerGroupFactory extends ModelFactory
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
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CustomerGroup $customerGroup): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerGroup::class;
    }
}

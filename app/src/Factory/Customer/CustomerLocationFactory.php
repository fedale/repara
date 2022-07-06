<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerLocation;
use App\Repository\Customer\CustomerLocationRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerLocation>
 *
 * @method static CustomerLocation|Proxy createOne(array $attributes = [])
 * @method static CustomerLocation[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerLocation|Proxy find(object|array|mixed $criteria)
 * @method static CustomerLocation|Proxy findOrCreate(array $attributes)
 * @method static CustomerLocation|Proxy first(string $sortedField = 'id')
 * @method static CustomerLocation|Proxy last(string $sortedField = 'id')
 * @method static CustomerLocation|Proxy random(array $attributes = [])
 * @method static CustomerLocation|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerLocation[]|Proxy[] all()
 * @method static CustomerLocation[]|Proxy[] findBy(array $attributes)
 * @method static CustomerLocation[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerLocation[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CustomerLocationRepository|RepositoryProxy repository()
 * @method CustomerLocation|Proxy create(array|callable $attributes = [])
 */
final class CustomerLocationFactory extends ModelFactory
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
            'name' => self::faker()->text(128),
            'address' => self::faker()->text(64),
            'zipcode' => self::faker()->text(8),
            'city' => self::faker()->text(64),
            'country' => self::faker()->text(32),
            'active' => self::faker()->boolean(),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-6 months'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year'),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CustomerLocation $customerLocation): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerLocation::class;
    }
}

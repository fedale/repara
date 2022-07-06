<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerLocationPlace;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerLocationPlace>
 *
 * @method static CustomerLocationPlace|Proxy createOne(array $attributes = [])
 * @method static CustomerLocationPlace[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerLocationPlace|Proxy find(object|array|mixed $criteria)
 * @method static CustomerLocationPlace|Proxy findOrCreate(array $attributes)
 * @method static CustomerLocationPlace|Proxy first(string $sortedField = 'id')
 * @method static CustomerLocationPlace|Proxy last(string $sortedField = 'id')
 * @method static CustomerLocationPlace|Proxy random(array $attributes = [])
 * @method static CustomerLocationPlace|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerLocationPlace[]|Proxy[] all()
 * @method static CustomerLocationPlace[]|Proxy[] findBy(array $attributes)
 * @method static CustomerLocationPlace[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerLocationPlace[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method CustomerLocationPlace|Proxy create(array|callable $attributes = [])
 */
final class CustomerLocationPlaceFactory extends ModelFactory
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
            'active' => self::faker()->boolean(),
            // 'createdAt' => null, // TODO add DATETIME ORM type manually
            // 'updatedAt' => null, // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CustomerLocationPlace $customerLocationPlace): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerLocationPlace::class;
    }
}

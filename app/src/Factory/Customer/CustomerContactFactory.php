<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerContact;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerContact>
 *
 * @method static CustomerContact|Proxy createOne(array $attributes = [])
 * @method static CustomerContact[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerContact|Proxy find(object|array|mixed $criteria)
 * @method static CustomerContact|Proxy findOrCreate(array $attributes)
 * @method static CustomerContact|Proxy first(string $sortedField = 'id')
 * @method static CustomerContact|Proxy last(string $sortedField = 'id')
 * @method static CustomerContact|Proxy random(array $attributes = [])
 * @method static CustomerContact|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerContact[]|Proxy[] all()
 * @method static CustomerContact[]|Proxy[] findBy(array $attributes)
 * @method static CustomerContact[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerContact[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method CustomerContact|Proxy create(array|callable $attributes = [])
 */
final class CustomerContactFactory extends ModelFactory
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
            'firstname' => self::faker()->text(),
            'lastname' => self::faker()->text(),
            'active' => self::faker()->boolean(),
            'createdAt' => null, // TODO add TIMESTAMP ORM type manually
            'updatedAt' => null, // TODO add TIMESTAMP ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CustomerContact $customerContact): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerContact::class;
    }
}

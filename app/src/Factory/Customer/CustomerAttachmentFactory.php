<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerAttachment;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerAttachment>
 *
 * @method static CustomerAttachment|Proxy createOne(array $attributes = [])
 * @method static CustomerAttachment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerAttachment|Proxy find(object|array|mixed $criteria)
 * @method static CustomerAttachment|Proxy findOrCreate(array $attributes)
 * @method static CustomerAttachment|Proxy first(string $sortedField = 'id')
 * @method static CustomerAttachment|Proxy last(string $sortedField = 'id')
 * @method static CustomerAttachment|Proxy random(array $attributes = [])
 * @method static CustomerAttachment|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerAttachment[]|Proxy[] all()
 * @method static CustomerAttachment[]|Proxy[] findBy(array $attributes)
 * @method static CustomerAttachment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerAttachment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method CustomerAttachment|Proxy create(array|callable $attributes = [])
 */
final class CustomerAttachmentFactory extends ModelFactory
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
            'type' => self::faker()->text(),
            'size' => self::faker()->randomNumber(),
            'path' => self::faker()->text(),
            'filename' => self::faker()->text(),
            'active' => self::faker()->boolean(),
            'createdAt' => null, // TODO add DATETIME ORM type manually
            'updatedAt' => null, // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CustomerAttachment $customerAttachment): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerAttachment::class;
    }
}

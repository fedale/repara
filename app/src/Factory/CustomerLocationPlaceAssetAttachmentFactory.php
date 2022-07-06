<?php

namespace App\Factory;

use App\Entity\Customer\CustomerLocationPlaceAssetAttachment;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerLocationPlaceAssetAttachment>
 *
 * @method static CustomerLocationPlaceAssetAttachment|Proxy createOne(array $attributes = [])
 * @method static CustomerLocationPlaceAssetAttachment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerLocationPlaceAssetAttachment|Proxy find(object|array|mixed $criteria)
 * @method static CustomerLocationPlaceAssetAttachment|Proxy findOrCreate(array $attributes)
 * @method static CustomerLocationPlaceAssetAttachment|Proxy first(string $sortedField = 'id')
 * @method static CustomerLocationPlaceAssetAttachment|Proxy last(string $sortedField = 'id')
 * @method static CustomerLocationPlaceAssetAttachment|Proxy random(array $attributes = [])
 * @method static CustomerLocationPlaceAssetAttachment|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerLocationPlaceAssetAttachment[]|Proxy[] all()
 * @method static CustomerLocationPlaceAssetAttachment[]|Proxy[] findBy(array $attributes)
 * @method static CustomerLocationPlaceAssetAttachment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerLocationPlaceAssetAttachment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method CustomerLocationPlaceAssetAttachment|Proxy create(array|callable $attributes = [])
 */
final class CustomerLocationPlaceAssetAttachmentFactory extends ModelFactory
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
            // ->afterInstantiate(function(CustomerLocationPlaceAssetAttachment $customerLocationPlaceAssetAttachment): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerLocationPlaceAssetAttachment::class;
    }
}

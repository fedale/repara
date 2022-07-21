<?php

namespace App\Factory\Customer;

use App\Entity\Customer\CustomerLocationPlaceAsset;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<CustomerLocationPlaceAsset>
 *
 * @method static CustomerLocationPlaceAsset|Proxy createOne(array $attributes = [])
 * @method static CustomerLocationPlaceAsset[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static CustomerLocationPlaceAsset|Proxy find(object|array|mixed $criteria)
 * @method static CustomerLocationPlaceAsset|Proxy findOrCreate(array $attributes)
 * @method static CustomerLocationPlaceAsset|Proxy first(string $sortedField = 'id')
 * @method static CustomerLocationPlaceAsset|Proxy last(string $sortedField = 'id')
 * @method static CustomerLocationPlaceAsset|Proxy random(array $attributes = [])
 * @method static CustomerLocationPlaceAsset|Proxy randomOrCreate(array $attributes = [])
 * @method static CustomerLocationPlaceAsset[]|Proxy[] all()
 * @method static CustomerLocationPlaceAsset[]|Proxy[] findBy(array $attributes)
 * @method static CustomerLocationPlaceAsset[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static CustomerLocationPlaceAsset[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method CustomerLocationPlaceAsset|Proxy create(array|callable $attributes = [])
 */
final class CustomerLocationPlaceAssetFactory extends ModelFactory
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
            'code' => self::faker()->text(),
            'customerLocationPlaceId' => self::faker()->randomNumber(),
            'assetId' => self::faker()->randomNumber(),
            'active' => self::faker()->boolean(),
            'createdAt' => null, // TODO add DATETIME ORM type manually
            'updatedAt' => null, // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(CustomerLocationPlaceAsset $customerLocationPlaceAsset): void {})
        ;
    }

    protected static function getClass(): string
    {
        return CustomerLocationPlaceAsset::class;
    }
}

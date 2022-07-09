<?php

namespace App\Factory\Asset;

use App\Entity\Asset\AssetType;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<AssetType>
 *
 * @method static AssetType|Proxy createOne(array $attributes = [])
 * @method static AssetType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AssetType|Proxy find(object|array|mixed $criteria)
 * @method static AssetType|Proxy findOrCreate(array $attributes)
 * @method static AssetType|Proxy first(string $sortedField = 'id')
 * @method static AssetType|Proxy last(string $sortedField = 'id')
 * @method static AssetType|Proxy random(array $attributes = [])
 * @method static AssetType|Proxy randomOrCreate(array $attributes = [])
 * @method static AssetType[]|Proxy[] all()
 * @method static AssetType[]|Proxy[] findBy(array $attributes)
 * @method static AssetType[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AssetType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method AssetType|Proxy create(array|callable $attributes = [])
 */
final class AssetTypeFactory extends ModelFactory
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
            'name' => self::faker()->text(10),
            'active' => self::faker()->boolean(0),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 year'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(AssetType $assetType): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AssetType::class;
    }
}

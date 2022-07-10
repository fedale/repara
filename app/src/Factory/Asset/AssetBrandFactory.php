<?php

namespace App\Factory\Asset;

use App\Entity\Asset\AssetBrand;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<AssetBrand>
 *
 * @method static AssetBrand|Proxy createOne(array $attributes = [])
 * @method static AssetBrand[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AssetBrand|Proxy find(object|array|mixed $criteria)
 * @method static AssetBrand|Proxy findOrCreate(array $attributes)
 * @method static AssetBrand|Proxy first(string $sortedField = 'id')
 * @method static AssetBrand|Proxy last(string $sortedField = 'id')
 * @method static AssetBrand|Proxy random(array $attributes = [])
 * @method static AssetBrand|Proxy randomOrCreate(array $attributes = [])
 * @method static AssetBrand[]|Proxy[] all()
 * @method static AssetBrand[]|Proxy[] findBy(array $attributes)
 * @method static AssetBrand[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AssetBrand[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method AssetBrand|Proxy create(array|callable $attributes = [])
 */
final class AssetBrandFactory extends ModelFactory
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
            'active' => self::faker()->boolean(50),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 year'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(AssetBrand $assetBrand): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AssetBrand::class;
    }
}

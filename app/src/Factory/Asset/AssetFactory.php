<?php

namespace App\Factory\Asset;

use App\Entity\Asset\Asset;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Asset>
 *
 * @method static Asset|Proxy createOne(array $attributes = [])
 * @method static Asset[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Asset|Proxy find(object|array|mixed $criteria)
 * @method static Asset|Proxy findOrCreate(array $attributes)
 * @method static Asset|Proxy first(string $sortedField = 'id')
 * @method static Asset|Proxy last(string $sortedField = 'id')
 * @method static Asset|Proxy random(array $attributes = [])
 * @method static Asset|Proxy randomOrCreate(array $attributes = [])
 * @method static Asset[]|Proxy[] all()
 * @method static Asset[]|Proxy[] findBy(array $attributes)
 * @method static Asset[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Asset[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method Asset|Proxy create(array|callable $attributes = [])
 */
final class AssetFactory extends ModelFactory
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
            'active' => self::faker()->boolean(50),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 year'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Asset $asset): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Asset::class;
    }
}

<?php

namespace App\Factory\Asset;

use App\Entity\Asset\AssetModel;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<AssetModel>
 *
 * @method static AssetModel|Proxy createOne(array $attributes = [])
 * @method static AssetModel[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AssetModel|Proxy find(object|array|mixed $criteria)
 * @method static AssetModel|Proxy findOrCreate(array $attributes)
 * @method static AssetModel|Proxy first(string $sortedField = 'id')
 * @method static AssetModel|Proxy last(string $sortedField = 'id')
 * @method static AssetModel|Proxy random(array $attributes = [])
 * @method static AssetModel|Proxy randomOrCreate(array $attributes = [])
 * @method static AssetModel[]|Proxy[] all()
 * @method static AssetModel[]|Proxy[] findBy(array $attributes)
 * @method static AssetModel[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AssetModel[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method AssetModel|Proxy create(array|callable $attributes = [])
 */
final class AssetModelFactory extends ModelFactory
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
            'type' => AssetModelFactory::new(),
            'active' => self::faker()->boolean(70),
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 year'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(AssetModel $assetModel): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AssetModel::class;
    }
}

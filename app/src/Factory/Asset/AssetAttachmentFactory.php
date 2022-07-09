<?php

namespace App\Factory\Asset;

use App\Entity\Asset\AssetAttachment;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<AssetAttachment>
 *
 * @method static AssetAttachment|Proxy createOne(array $attributes = [])
 * @method static AssetAttachment[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static AssetAttachment|Proxy find(object|array|mixed $criteria)
 * @method static AssetAttachment|Proxy findOrCreate(array $attributes)
 * @method static AssetAttachment|Proxy first(string $sortedField = 'id')
 * @method static AssetAttachment|Proxy last(string $sortedField = 'id')
 * @method static AssetAttachment|Proxy random(array $attributes = [])
 * @method static AssetAttachment|Proxy randomOrCreate(array $attributes = [])
 * @method static AssetAttachment[]|Proxy[] all()
 * @method static AssetAttachment[]|Proxy[] findBy(array $attributes)
 * @method static AssetAttachment[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static AssetAttachment[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method AssetAttachment|Proxy create(array|callable $attributes = [])
 */
final class AssetAttachmentFactory extends ModelFactory
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
            'createdAt' => self::faker()->dateTimeBetween('-3 years', '-1 year'),
            'updatedAt' => self::faker()->dateTimeBetween('-1 year')
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(AssetAttachment $assetAttachment): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AssetAttachment::class;
    }
}

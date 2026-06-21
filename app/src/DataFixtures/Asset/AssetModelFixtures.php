<?php

namespace App\DataFixtures\Asset;

use App\DataFixtures\Domain\DomainProfileProvider;
use App\DataFixtures\SlugifyTrait;
use App\Entity\Asset\AssetBrand;
use App\Entity\Asset\AssetModel;
use App\Entity\Asset\AssetType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AssetModelFixtures extends Fixture implements DependentFixtureInterface
{
    use SlugifyTrait;

    public function __construct(private readonly DomainProfileProvider $domains)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $series = $this->domains->get()->assetModelSeries();

        $assetBrands = $manager->getRepository(AssetBrand::class)->findAll();
        $assetTypes = $manager->getRepository(AssetType::class)->findAll();

        foreach (range(1, 100) as $model) {
            $name = \sprintf(
                '%s %s',
                $series[array_rand($series)],
                strtoupper($faker->bothify('??-###'))
            );

            $assetModel = new AssetModel();
            $assetModel->setName($name);
            $assetModel->setSlug($this->slugify($name . '-' . $model));
            $assetModel->setBrand($assetBrands[array_rand($assetBrands)]);
            $assetModel->setType($assetTypes[array_rand($assetTypes)]);
            $manager->persist($assetModel);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AssetBrandFixtures::class,
            AssetTypeFixtures::class
        ];
    }
}

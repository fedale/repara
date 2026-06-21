<?php

namespace App\DataFixtures\Asset;

use App\DataFixtures\Domain\DomainProfileProvider;
use App\DataFixtures\SlugifyTrait;
use App\Entity\Asset\Asset;
use App\Entity\Asset\AssetModel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AssetFixtures extends Fixture implements DependentFixtureInterface
{
    use SlugifyTrait;

    public function __construct(private readonly DomainProfileProvider $domains)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('it_IT');
        $domain = $this->domains->get();

        $equipments = $domain->assetEquipment();
        $brands = $domain->assetBrands();

        $assetModels = $manager->getRepository(AssetModel::class)->findAll();

        foreach (range(1, 5000) as $asset) {
            $equipment = $equipments[array_rand($equipments)];
            $brand = $brands[array_rand($brands)];
            $reference = $faker->bothify('??-####');

            $assetModel = new Asset();
            $assetModel->setName(\sprintf('%s %s %s', $equipment, $brand, $reference));
            $assetModel->setSlug($this->slugify(\sprintf('%s-%s-%d', $equipment, $brand, $asset)));
            $assetModel->setModel($assetModels[array_rand($assetModels)]);
            $manager->persist($assetModel);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AssetModelFixtures::class,
        ];
    }
}

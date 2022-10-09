<?php

namespace App\DataFixtures\Asset;

use App\Entity\Asset\AssetBrand;
use App\Entity\Asset\AssetModel;
use App\Entity\Asset\AssetType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssetModelFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $assetBrands = $manager->getRepository(AssetBrand::class)->findAll();
        $assetTypes = $manager->getRepository(AssetType::class)->findAll();

        foreach (range(1, 100) as $model) {
            $assetModel = new AssetModel();
            $assetModel->setName('Model ' . $model);
            $assetModel->setSlug('model-' . $model);
            $assetModel->setBrand($assetBrands[array_rand($assetBrands)]);
            $assetModel->setType($assetTypes[array_rand($assetTypes)]);
            $manager->persist($assetModel);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AssetBrandFixtures::class,
            AssetTypeFixtures::class
        ];
    }
}

<?php

namespace App\DataFixtures\Asset;

use App\Entity\Asset\Asset;
use App\Entity\Asset\AssetModel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssetFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $assetModels = $manager->getRepository(AssetModel::class)->findAll();

        foreach (range(1, 5000) as $asset) {
            $assetModel = new Asset();
            $assetModel->setName('Asset ' . $asset);
            $assetModel->setSlug('asset-' . $asset);
            $assetModel->setModel($assetModels[array_rand($assetModels)]);
            $manager->persist($assetModel);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AssetModelFixtures::class,
        ];
    }
}
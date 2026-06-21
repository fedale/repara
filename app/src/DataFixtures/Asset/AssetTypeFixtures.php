<?php

namespace App\DataFixtures\Asset;

use App\DataFixtures\Domain\DomainProfileProvider;
use App\DataFixtures\SlugifyTrait;
use App\Entity\Asset\AssetType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssetTypeFixtures extends Fixture
{
    use SlugifyTrait;

    public function __construct(private readonly DomainProfileProvider $domains)
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->domains->get()->assetTypes() as $name) {
            $assetType = new AssetType();
            $assetType->setName($name);
            $assetType->setSlug($this->slugify($name));
            $manager->persist($assetType);
        }

        $manager->flush();
    }
}

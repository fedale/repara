<?php

namespace App\DataFixtures\Asset;

use App\Entity\Asset\AssetBrand;
use App\Factory\Asset\AssetBrandFactory;
use App\Factory\Asset\AssetTypeFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AssetBrandFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach ( $this->getAssetBrands() as $brandName) {
            $assetBrand = new AssetBrand();
            $assetBrand->setName($brandName);
            $assetBrand->setActive(true);
            $manager->persist($assetBrand);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AssetTypeFixtures::class,
        ];
    }

    private function getAssetBrands() {
        // https://www.climamarket.it/brand # list all brands
        // https://www.climamarket.it/brand/<brand> # get info on specific brand
        return [
            'Ariston',
            'Arkema',
            'Atlantic',
            'Austroflex',
            'Bampi',
            'Baxi',
            'Beretta',
            'Black Bull',
            'Bonomini',
            'Cadel',
            'Caleffi',
            'Caminetti Montegrappa',
            'Carrier',
            'Chigo',
            'Climaveneta',
            'Clivet',
            'CO.EL.TE',
            'Cordivari',
            'Dab',
            'Daikin',
            'Daitsu',
            'Edilkamin',
            'Ercos',
            'FAR',
            'Ferroli',
            'Fima Carlo Frattini',
            'Fischer Italia S.r.l.',
            'Fondital',
            'Fujitsu',
            'Galletti',
            'Geberit',
            'Gedy',
            'Gel',
            'Girolami',
            'Global Water Solutions',
            'Grundfos',
            'Hisense',
            'Hisense',
            'Immergas',
            'Italiana Camini',
            'Ivar',
            'Jacuzzi',
            'Junkers',
            'Klover',
            'Kme',
            'LG',
            'Lowara',
            'MCZ',
            'Midea',
            'Mitsubishi Electric',
            'Niccons',
            'Olimpia Splendid',
            'Piralla',
            'Pleion',
            'Pozzi Ginori',
            'Rinnai',
            'Sabiana',
            'Samsung',
            'Sanitrit Sfa',
            'Seitron',
            'Simat',
            'Stabile',
            'STEELPUMPS',
            'Tecnosystemi',
            'Toshiba',
            'Vaillant',
            'VMD Italia',
            'Vortice',
            'Zucchetti',
        ];
    }
}
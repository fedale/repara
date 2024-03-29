<?php

namespace App\Repository\Asset;

use App\Entity\Asset\AssetCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssetCategory>
 *
 * @method AssetCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetCategory[]    findAll()
 * @method AssetCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssetCategory::class);
    }

    public function add(AssetCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssetCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

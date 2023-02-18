<?php

namespace App\Repository\Asset;

use App\Entity\Asset\Asset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Asset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Asset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Asset[]    findAll()
 * @method Asset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerLocationPlaceAsset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 * @method CustomerLocationPlaceAsset|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerLocationPlaceAsset|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerLocationPlaceAsset[]    findAll()
 * @method CustomerLocationPlaceAsset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLocationPlaceAssetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerLocationPlaceAsset::class);
    }

    public function add(CustomerLocationPlaceAsset $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerLocationPlaceAsset $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return CustomerLocationPlaceAsset[] Returns an array of CustomerLocation objects
     */
    public function findByCustomer($customer = null): array
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getResult()
        ;
    }

    
//    public function findOneBySomeField($value): ?CustomerLocation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

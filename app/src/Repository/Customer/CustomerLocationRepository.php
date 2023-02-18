<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 *
 * @method CustomerLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerLocation[]    findAll()
 * @method CustomerLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerLocation::class);
    }

    public function add(CustomerLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

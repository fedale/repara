<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerGroup>
 *
 * @method CustomerGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerGroup[]    findAll()
 * @method CustomerGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerGroup::class);
    }

    public function add(CustomerGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

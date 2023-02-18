<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerRole;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CustomerRole>
 *
 * @method CustomerRole|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerRole|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerRole[]    findAll()
 * @method CustomerRole[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CustomerRole::class);
    }

    public function add(CustomerRole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerRole $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

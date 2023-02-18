<?php

namespace App\Repository\User;

use App\Entity\User\UserGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserGroup>
 *
 * @method UserGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGroup[]    findAll()
 * @method UserGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGroup::class);
    }

    public function add(UserGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

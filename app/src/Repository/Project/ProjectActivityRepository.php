<?php

namespace App\Repository\Project;

use App\Entity\Project\ProjectActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectActivity>
 *
 * @method ProjectActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectActivity[]    findAll()
 * @method ProjectActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectActivity::class);
    }

    public function add(ProjectActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

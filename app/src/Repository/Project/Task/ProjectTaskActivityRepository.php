<?php

namespace App\Repository\Project\Task;

use App\Entity\Project\Task\ProjectTaskActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectTaskActivity>
 *
 * @method ProjectTaskActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTaskActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTaskActivity[]    findAll()
 * @method ProjectTaskActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTaskActivity::class);
    }

    public function add(ProjectTaskActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectTaskActivity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

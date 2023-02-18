<?php

namespace App\Repository\Project\Task;

use App\Entity\Project\Task\ProjectTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectTask>
 *
 * @method ProjectTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTask[]    findAll()
 * @method ProjectTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTask::class);
    }

    public function add(ProjectTask $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectTask $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

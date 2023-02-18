<?php

namespace App\Repository\Project\Task;

use App\Entity\Project\Task\ProjectTaskTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectTaskTag>
 *
 * @method ProjectTaskTag|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTaskTag|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTaskTag[]    findAll()
 * @method ProjectTaskTag[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskTagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTaskTag::class);
    }

    public function add(ProjectTaskTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectTaskTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

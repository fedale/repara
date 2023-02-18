<?php

namespace App\Repository\Project\TaskTemplate;

use App\Entity\Project\TaskTemplate\ProjectTaskTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProjectTaskTemplate>
 *
 * @method ProjectTaskTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTaskTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTaskTemplate[]    findAll()
 * @method ProjectTaskTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectTaskTemplate::class);
    }

    public function add(ProjectTaskTemplate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProjectTaskTemplate $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

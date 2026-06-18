<?php

namespace App\Repository\Project\Task;

use App\Entity\Project\Task\ProjectTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

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
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, ProjectTask::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('pt')
            ->select('pt', 'c', 'cpa', 'ty')
            ->leftJoin('pt.customer', 'c')
            ->leftJoin('pt.customerLocationPlaceAsset', 'cpa')
            ->leftJoin('pt.type', 'ty')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'     => ['text',     'pt.name'],
            'state'    => ['text',     'pt.state'],
            'priority' => ['text',     'pt.priority'],
            'active'   => ['boolean',  'pt.active'],
            'customer' => ['relation', 'c.id'],
            'type'     => ['relation', 'ty.id'],
        ]);

        return $qb;
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

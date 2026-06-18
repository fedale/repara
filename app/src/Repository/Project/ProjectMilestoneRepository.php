<?php

namespace App\Repository\Project;

use App\Entity\Project\ProjectMilestone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<ProjectMilestone>
 *
 * @method ProjectMilestone|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectMilestone|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectMilestone[]    findAll()
 * @method ProjectMilestone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectMilestoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, ProjectMilestone::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m', 'p')
            ->leftJoin('m.project', 'p')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'    => ['text',     'm.name'],
            'active'  => ['boolean',  'm.active'],
            'project' => ['relation', 'p.id'],
        ]);

        return $qb;
    }
}

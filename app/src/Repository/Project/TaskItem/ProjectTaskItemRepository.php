<?php

namespace App\Repository\Project\TaskItem;

use App\Entity\Project\TaskItem\ProjectTaskItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<ProjectTaskItem>
 *
 * @method ProjectTaskItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTaskItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTaskItem[]    findAll()
 * @method ProjectTaskItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, ProjectTaskItem::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i', 'pt')
            ->leftJoin('i.projectTask', 'pt')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'        => ['text',     'i.name'],
            'value'       => ['text',     'i.value'],
            'active'      => ['boolean',  'i.active'],
            'projectTask' => ['relation', 'pt.id'],
        ]);

        return $qb;
    }
}

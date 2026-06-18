<?php

namespace App\Repository\Project\TaskTemplate;

use App\Entity\Project\TaskTemplate\ProjectTaskItemTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<ProjectTaskItemTemplate>
 *
 * @method ProjectTaskItemTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectTaskItemTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectTaskItemTemplate[]    findAll()
 * @method ProjectTaskItemTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectTaskItemTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, ProjectTaskItemTemplate::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('i')
            ->select('i', 'tt', 'ty')
            ->leftJoin('i.taskTemplate', 'tt')
            ->leftJoin('i.taskType', 'ty')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'         => ['text',     'i.name'],
            'active'       => ['boolean',  'i.active'],
            'taskTemplate' => ['relation', 'tt.id'],
            'taskType'     => ['relation', 'ty.id'],
        ]);

        return $qb;
    }
}

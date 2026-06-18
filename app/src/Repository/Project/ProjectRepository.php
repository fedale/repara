<?php

namespace App\Repository\Project;

use App\Entity\Project\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, Project::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 't')
            ->leftJoin('p.type', 't')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'code'   => ['text',     'p.code'],
            'name'   => ['text',     'p.name'],
            'status' => ['text',     'p.status'],
            'type'   => ['relation', 't.id'],
        ]);

        return $qb;
    }
}

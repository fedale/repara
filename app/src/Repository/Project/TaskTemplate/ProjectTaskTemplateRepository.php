<?php

namespace App\Repository\Project\TaskTemplate;

use App\Entity\Project\TaskTemplate\ProjectTaskTemplate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

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
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, ProjectTaskTemplate::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('tt')->select('tt');

        $this->searchForm->applyFilters($qb, $params, [
            'name'   => ['text',    'tt.name'],
            'active' => ['boolean', 'tt.active'],
        ]);

        return $qb;
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

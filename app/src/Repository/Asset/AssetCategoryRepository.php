<?php

namespace App\Repository\Asset;

use App\Entity\Asset\AssetCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<AssetCategory>
 *
 * @method AssetCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetCategory[]    findAll()
 * @method AssetCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, AssetCategory::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('c')
            ->select('c', 'p')
            ->leftJoin('c.parent', 'p')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'   => ['text',     'c.name'],
            'slug'   => ['text',     'c.slug'],
            'active' => ['boolean',  'c.active'],
            'parent' => ['relation', 'p.id'],
        ]);

        return $qb;
    }

    public function add(AssetCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssetCategory $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

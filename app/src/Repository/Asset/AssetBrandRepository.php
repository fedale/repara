<?php

namespace App\Repository\Asset;

use App\Entity\Asset\AssetBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<AssetBrand>
 *
 * @method AssetBrand|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetBrand|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetBrand[]    findAll()
 * @method AssetBrand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetBrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, AssetBrand::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('b')->select('b');

        $this->searchForm->applyFilters($qb, $params, [
            'name'   => ['text',    'b.name'],
            'slug'   => ['text',    'b.slug'],
            'active' => ['boolean', 'b.active'],
        ]);

        return $qb;
    }
}

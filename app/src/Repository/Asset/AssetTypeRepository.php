<?php

namespace App\Repository\Asset;

use App\Entity\Asset\AssetType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<AssetType>
 *
 * @method AssetType|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetType|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetType[]    findAll()
 * @method AssetType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, AssetType::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('t')->select('t');

        $this->searchForm->applyFilters($qb, $params, [
            'name'   => ['text',    't.name'],
            'slug'   => ['text',    't.slug'],
            'active' => ['boolean', 't.active'],
        ]);

        return $qb;
    }
}

<?php

namespace App\Repository\Asset;

use App\Entity\Asset\AssetModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<AssetModel>
 *
 * @method AssetModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetModel[]    findAll()
 * @method AssetModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, AssetModel::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('m')
            ->select('m', 'b', 't')
            ->leftJoin('m.brand', 'b')
            ->leftJoin('m.type', 't')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'   => ['text',     'm.name'],
            'slug'   => ['text',     'm.slug'],
            'active' => ['boolean',  'm.active'],
            'brand'  => ['relation', 'b.id'],
            'type'   => ['relation', 't.id'],
        ]);

        return $qb;
    }
}

<?php

namespace App\Repository\Asset;

use App\Entity\Asset\AssetAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<AssetAttachment>
 *
 * @method AssetAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssetAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssetAttachment[]    findAll()
 * @method AssetAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssetAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, AssetAttachment::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a', 'ast')
            ->leftJoin('a.asset', 'ast')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'   => ['text',     'a.name'],
            'type'   => ['text',     'a.type'],
            'active' => ['boolean',  'a.active'],
            'asset'  => ['relation', 'ast.id'],
        ]);

        return $qb;
    }
}

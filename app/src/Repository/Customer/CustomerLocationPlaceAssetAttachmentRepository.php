<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerLocationPlaceAssetAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<CustomerLocationPlaceAssetAttachment>
 *
 * @method CustomerLocationPlaceAssetAttachment|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerLocationPlaceAssetAttachment|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerLocationPlaceAssetAttachment[]    findAll()
 * @method CustomerLocationPlaceAssetAttachment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLocationPlaceAssetAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, CustomerLocationPlaceAssetAttachment::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a', 'cpa')
            ->leftJoin('a.customerLocationPlaceAsset', 'cpa')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'                      => ['text',     'a.name'],
            'type'                      => ['text',     'a.type'],
            'active'                    => ['boolean',  'a.active'],
            'customerLocationPlaceAsset' => ['relation', 'cpa.id'],
        ]);

        return $qb;
    }
}

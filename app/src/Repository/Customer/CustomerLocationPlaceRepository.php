<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerLocationPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<CustomerLocationPlace>
 *
 * @method CustomerLocationPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerLocationPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerLocationPlace[]    findAll()
 * @method CustomerLocationPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLocationPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, CustomerLocationPlace::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p', 'l')
            ->leftJoin('p.customerLocation', 'l')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'             => ['text',     'p.name'],
            'active'           => ['boolean',  'p.active'],
            'customerLocation' => ['relation', 'l.id'],
        ]);

        return $qb;
    }
}

<?php

namespace App\Repository\Customer;

use App\Entity\Customer\CustomerLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 *
 * @method CustomerLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CustomerLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CustomerLocation[]    findAll()
 * @method CustomerLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, CustomerLocation::class);
    }

    /** QueryBuilder consumed by the gridview EntityDataProvider. */
    public function search(array $params = []): QueryBuilder
    {
        $qb = $this->createQueryBuilder('l')
            ->select('l', 'c')
            ->leftJoin('l.customer', 'c')
        ;

        $this->searchForm->applyFilters($qb, $params, [
            'name'     => ['text',     'l.name'],
            'address'  => ['text',     'l.address'],
            'city'     => ['text',     'l.city'],
            'active'   => ['boolean',  'l.active'],
            'customer' => ['relation', 'c.id'],
        ]);

        return $qb;
    }

    public function add(CustomerLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CustomerLocation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}

<?php

namespace App\Repository\Customer;

use App\Entity\Customer\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Form\SearchForm;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private SearchForm $searchForm)
    {
        parent::__construct($registry, Customer::class);
    }

    public function add(Customer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Customer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function search(array $params = [])
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c', 'p', 'l', 't', 'r', 'g')
            ->distinct()
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
            ->join('c.type', 't')
            ->leftJoin('c.roles', 'r')
            ->leftJoin('c.groups', 'g')
        ;

        // Per-type filter logic (date range parsing, boolean cast, IN, ...)
        // lives in the bundle appliers; the map declares param key => [type, DQL field]
        $this->searchForm->applyFilters($qb, $params, [
            'code'      => ['text',     'c.code'],
            'email'     => ['text',     'c.email'],
            'active'    => ['boolean',  'c.active'],
            'createdAt' => ['date',     'c.createdAt'],
            'locations' => ['relation', 'l.id'],
            'type'      => ['relation', 't.id'],
            'groups'    => ['relation', 'g.id'],
        ]);

        // Genuinely custom condition: fullname matches any of several fields
        $this->searchForm->andFilterWhere(
            $qb,
            'or',
            ['ilike', 'p.firstname', $params['profile_fullname'] ?? null],
            ['ilike', 'p.lastname', $params['profile_fullname'] ?? null],
            ['ilike', 'CONCAT(p.firstname, \' \', p.lastname)', $params['profile_fullname'] ?? null],
            ['ilike', 'CONCAT(p.lastname, \' \', p.firstname)', $params['profile_fullname'] ?? null],
            ['ilike', 'c.email', $params['profile_fullname'] ?? null],
        );

        // The "username" column filter searches across username, code and the
        // full name (firstname/lastname matched in either order).
        $this->searchForm->andFilterWhere(
            $qb,
            'or',
            ['ilike', 'c.username', $params['username'] ?? null],
            ['ilike', 'c.code', $params['username'] ?? null],
            ['ilike', 'p.firstname', $params['username'] ?? null],
            ['ilike', 'p.lastname', $params['username'] ?? null],
            ['ilike', 'CONCAT(p.firstname, \' \', p.lastname)', $params['username'] ?? null],
            ['ilike', 'CONCAT(p.lastname, \' \', p.firstname)', $params['username'] ?? null],
        );

        return $qb;
    }
}

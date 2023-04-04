<?php

namespace App\Repository\Customer;

use App\Entity\Customer\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

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
    public function __construct(ManagerRegistry $registry)
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

    public function findAllModels()
    {
        return $this
            ->createQueryBuilder('c')
            ->select('c ', 'p', 'l')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
        ;
    } 

    public function search(QueryBuilder $qb)
    {
        /**
         * ++++++++++ What I want to achieve ++++++++++++
         * // We have to do some search... Lets do some magic
         *   $query->andFilterWhere([
         *      //... other searched attributes here
         *   ])
         * 
         *   // Here we search the attributes of our relations using our previously configured
         *   // ones in "TourSearch"
         *   ->andFilterWhere(['like', 'tbl_city.name', $this->city])
         *   ->andFilterWhere(['like', 'tbl_country.name', $this->country]);
         */
        dd($qb);
        return $qb
            ->andWhere($qb->expr()->like('p.firstname',  $qb->expr()->literal('Gui%')));
    }

}

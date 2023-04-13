<?php

namespace App\Repository\Customer;

use App\Entity\Customer\Customer;
use Fedale\GridviewBundle\Service\ServiceEntityRepository;
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

    /*
    public function findAllModels()
    {
        return $this
            ->createQueryBuilder('c')
            ->select('c ', 'p', 'l')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
        ;
    }*/

    public function search(array $params = [])
    {
        $criteria = Criteria::create();
        $expr = Criteria::expr();
        
        $qb = $this
            ->createQueryBuilder('c')
            ->select('c ', 'p', 'l')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
        ;

        if (count($params) === 0 ){
            return $qb;
        }


        $qb->andWhere('LOWER(l.zipcode) LIKE :locations')
            ->setParameter(':locations', '%' . strtolower($params['locations'] . '%')
        );
        

        // $fullname = strtolower($params['profile_fullname']);
        $fullname = $params['profile_fullname'];
        dump($fullname);
        $criteria->andWhere(
            $expr->orX(
                $expr->contains('p.firstname', $fullname),
                $expr->contains('p.lastname', $fullname),
            )
        );
        
        $qb->addCriteria($criteria);
        //$qb->setParameter(':fullname', '%' . $fullname . '%');

        /*
        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr->like('LOWER(p.firstname)', ':fullname'),
                $qb->expr()->like('LOWER(p.lastname)', ':fullname'),
                $qb->expr()->like(
                    $qb->expr()->concat('LOWER(p.firstname)', $qb->expr()->literal(' '), 'p.lastname'),
                    ':fullname'
                ),
            )
        )
            ->setParameter(':fullname', '%' . $fullname . '%')
        ;
        */
        return $qb;
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

         /**
          * maybe something like:
          * $filterService->andFilterWhere([$qb, 'like', $value, $attribute])
          * or
          * $this->andFilterWhere([$qb, 'like', $value, $attribute])
          */
    }

}

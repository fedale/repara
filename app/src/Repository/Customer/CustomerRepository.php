<?php

namespace App\Repository\Customer;

use App\Entity\Customer\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fedale\GridviewBundle\Service\SearchForm;

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
            ->select('c ', 'p', 'l', 't')
            ->join('c.profile', 'p')
            ->join('c.locations', 'l')
            ->join('c.type', 't')
        ;

        if (count($params) === 0 ){
            return $qb;
        }
        

        
         // Symfony way
         /*
        $qb->andWhere(
            $qb->expr()->like('l.zipcode', ':locations'),
        );
        $qb->setParameter('locations', '%' . $params['locations'] . '%');
        $qb->setParameter('locations2', '%' . $params['locations'] . '%');
        */
        
        // ->andFilterWhere(['like', 'tbl_city.name', $this->city]) // Yii2 way
        // My way
        
        $this->searchForm->orFilterWhere(
            $qb, 
            [
                'like',
                'l.zipcode',
                $params['locations']
            ],
            [
                'like',
                'l.zipcode',
                $params['locations']
            ],
            [
                'like',
                'l.zipcode',
                $params['locations']
            ]

        );
        

        /* 
        // Yii2 way with nested or/and
        // docs: https://www.yiiframework.com/doc/api/2.0/yii-db-queryinterface#where()-detail
        $query->andFilterWhere([
            'or',
            [
                'and',
                ['>=', 't1.price', $this>start_price],
                ['<=', 't1.price', $this->end_price]
            ],
            [
                'and',
                ['>=', 't2.price', $this->start_price],
                ['<=', 't2.price', $this->end_price]
            ]
        ]);
        */

        /*
        $qb->andWhere(
            $this->searchForm->search($qb, 'l.zipcode', $params['locations'])
        );*/
            
        /*
        $fullname = strtolower($params['profile_fullname']);
        $qb->andWhere(
            $qb->expr()->orX(
                $this->searchForm->search($qb, 'p.firstname', $fullname),
                $this->searchForm->search($qb, 'p.lastname', $fullname),
                $this->searchForm->search(
                    $qb,
                    $qb->expr()->concat('p.firstname', $qb->expr()->literal(' '), 'p.lastname'),
                    $fullname
                ),
                $this->searchForm->search(
                    $qb,
                    $qb->expr()->concat('p.lastname', $qb->expr()->literal(' '), 'p.firstname'),
                    $fullname
                ),
            )
        );
        */

        // $fullname = $params['profile_fullname'];
        // dump($fullname);
        // $criteria->andWhere(
        //     $expr->orX(
        //         $expr->contains('p.firstname', $fullname),
        //         $expr->contains('p.lastname', $fullname),
        //         $expr->contains('CONCAT(p.firstname, " ", p.lastname)', $fullname),
        //     )
        // );
        
        // $qb->addCriteria($criteria);
        // //$qb->setParameter(':fullname', '%' . $fullname . '%');

        /*
        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->like('LOWER(p.firstname)', ':fullname'),
                $qb->expr()->like('LOWER(p.lastname)', ':fullname'),
                $qb->expr()->like(
                    $qb->expr()->concat(
                        $qb->expr()->lower('p.firstname'), 
                        $qb->expr()->literal(' '), 
                        $qb->expr()->lower('p.lastname'), 
                    ),
                    ':fullname'
                ),
                $qb->expr()->like(
                    $qb->expr()->concat(
                        $qb->expr()->lower('p.lastname'), 
                        $qb->expr()->literal(' '), 
                        $qb->expr()->lower('p.firstname'), 
                    ),
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

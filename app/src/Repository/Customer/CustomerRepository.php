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
        

        /**
         * 
         */
        // First case: search in one field using LIKE
        /*
            $this->searchForm->andFilterWhere(
                $qb,
                [
                    'like',
                    'l.zipcode',
                    $params['locations']
                ]
            );
        */
        // Second case: search in more fields using LIKE
        /*
            $this->searchForm->andFilterWhere(
                $qb,
                [
                    'like',
                    'l.zipcode',
                    $params['locations']
                ],
                [
                    'like',
                    'secondField',
                    $params['otherParam']
                ]
            );
        */
        
         // Symfony way
         /*
        $qb->andWhere(
            $qb->expr()->like('l.zipcode', ':locations'),
        );
        $qb->setParameter('locations', '%' . $params['locations'] . '%');
        $qb->setParameter('locations2', '%' . $params['locations'] . '%');
        */
        /*
        $qb->where('o.foo = 1')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->eq('o.bar', 1),
                $qb->expr()->eq('o.bar', 2)
        ));
        */
        
        $this->searchForm->andFilterWhere(
            $qb,
            [
                'like',
                'c.code',
                $params['code']
            ]
        );
        // ->andFilterWhere(['like', 'tbl_city.name', $this->city]) // Yii2 way
        // My way: I want that this statement produces a condition like this:
        // AND (p.firstname LIKE %s OR p.lastname LIKE %s OR CONCAT(p.firstname, ' ', p.lastname) LIKE %s OR CONCAT (p.lastname, ' ', p.firstname) LIKE %s)
        $this->searchForm->andFilterWhere(
            $qb,
            'or', // conditional object to use (optional) could be 'and' or 'or'. By default it is the same as function
            [
                'ilike',
                'p.firstname',
                $params['profile_fullname']
            ],
            [
                'ilike',
                'p.lastname',
                $params['profile_fullname']
            ],
            [
                'ilike',
                'CONCAT(p.firstname, \' \', p.lastname)',
                $params['profile_fullname']
            ],
            [
                'ilike',
                'CONCAT(p.lastname, \' \', p.firstname)',
                $params['profile_fullname']
            ],
            [
                'ilike',
                'c.email',
                $params['profile_fullname']
            ],
        );

        
        $this->searchForm->andFilterWhere(
            $qb,
            [
                'ilike',
                'l.zipcode',
                $params['locations']
            ],
        );

/*
        $this->searchForm->andFilterWhere(
            $qb,
            [
                'like',
                'c.email',
                $params['email']
            ]
        );

        $this->searchForm->andFilterWhere(
            $qb,
            [
                'like', // operator
                'l.zipcode', // attribute
                $params['locations'] // param
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
  */      
       

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

        "AND WHERE 

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

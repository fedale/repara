<?php
namespace App\Grid\DataProvider;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class EntityDataProvider extends AbstractDataProvider
{
    private EntityManagerInterface $entityManager;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $queryBuilder;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $ormMetadata;


    //  /**
    //  * Inject dependencies
    //  *
    //  * @param Pagination $pagination
    //  * @param Sort $sort
    // TO DO...
    //  */
    // public function __construct(Pagination $pagination, Sort $sort){
    //     $this->pagination = $pagination;
    //     $this->sort = $sort;
    // }

    /**
     * @return QueryBuilder
     */
    public function getDataProvider(): QueryBuilder
    {
        return $this->dataProvider;
    }
    
    public function setQueryBuilder(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    public function prepare(bool $forcePrepare = false)
    {
        return $this->queryBuilder->getQuery()->getresult();
    }
}
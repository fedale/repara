<?php
namespace App\Grid\DataProvider;

use App\Grid\Component\Model;
use App\Grid\Serializer\ModelNormalizer;
use App\Grid\Component\Sort;
use App\Grid\Component\Pagination;
use App\Grid\Service\GridFilter;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Collections\ArrayCollection;

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

    private $paginator;

    public function __construct(
        protected Pagination $pagination, 
        protected Sort $sort, 
        private GridFilter $gridFilter
    ) {
        $this->models = new ArrayCollection();
    }

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

    public function getData()
    {
        $this->pagination->setTotalCount($this->getTotalCount());

        $this->queryBuilder
            ->setMaxResults($this->pagination->getPageSize())
            ->setFirstResult($this->pagination->getOffset())
        ;

        $sortParams = $this->getSort()->fetchOrders();

        foreach ($sortParams as $fieldName => $sortType) {
            $this->queryBuilder->addOrderBy($fieldName, $sortType);
        }

        $criteria = $this->gridFilter->getCriteria();
        if ($criteria) {
            $this->queryBuilder->addCriteria($criteria);    
        }

        // // Set paginator *after* sorting, criteria and so on.
        // $this->paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->queryBuilder, $fetchJoinCollection = true);
        // dump('totalCount: ' . $this->getTotalCount());
       
        
        $this->prepareData();

        return $this->models;
    }

    private function prepareData(bool $forcePrepare = false)
    {
        if (!$this->queryBuilder instanceof QueryBuilder) {
            // throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
            throw new \Exception('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        // $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        
        $normalizers = [new ObjectNormalizer($classMetadataFactory, null, null, null, null, null, $defaultContext)];
        $serializer = new Serializer($normalizers);

        $this->paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->queryBuilder, $fetchJoinCollection = true);
        foreach ($this->paginator as $model) {
            $model = $serializer->normalize($model);
            $this->models->add(new Model($model));
        }
    }

     /**
     * @inheritdoc
     */
    public function getTotalCount($criteria = []): int
    {
        // This Paginator serves total rows
        $this->paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->queryBuilder, $fetchJoinCollection = true);
        $totalRows = count($this->paginator);
        
        return $totalRows;
    }
}
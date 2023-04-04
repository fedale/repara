<?php
namespace Fedale\GridviewBundle\DataProvider;

use App\Entity\Customer\Customer;
use Fedale\GridviewBundle\Serializer\ModelNormalizer;
use Fedale\GridviewBundle\Component\Sort;
use Fedale\GridviewBundle\Component\Pagination;
use Fedale\GridviewBundle\Event\RowEvent;
use Fedale\GridviewBundle\Form\SearchModel;
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
use Fedale\GridviewBundle\Component\Row;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Fedale\GridviewBundle\EventSubscriber\RowSubscriber;

class EntityDataProvider extends AbstractDataProvider
{
    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected QueryBuilder $queryBuilder;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $ormMetadata;

    private $paginator;

    private int $totalRows;

      public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private EntityManagerInterface $entityManager
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


    public function prepareModels(string|array $models)
    {
        $this->queryBuilder = $this->entityManager->getRepository($models)->findAllModels();
    }

    public function getData()
    {
        $this->entityManager->getRepository(Customer::class)->search($this->queryBuilder);
        // First apply criteria
      //  $criteria = $this->searchModel->getCriteria();
        
      /*
        if ($criteria) {
            $this->queryBuilder->addCriteria($criteria);    
        }*/

        // Calculate totalCount with applied criterias
        $this->pagination->setTotalCount($this->getTotalCount());
        
        // Set offset and page size
        $this->queryBuilder
            ->setMaxResults($this->pagination->getPageSize())
            ->setFirstResult($this->pagination->getOffset())
        ;

        $sortParams = $this->getSort()->fetchOrders();

        foreach ($sortParams as $fieldName => $sortType) {
            $this->queryBuilder->addOrderBy($fieldName, $sortType);
        }

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
        
        $event = new RowEvent();
        foreach ($this->paginator as $key => $model) {
            $row = new Row($key, $this->pagination->getPageSize());
             
            $row->data = $serializer->normalize($model);            
            $event->row = $row;
            $this->eventDispatcher->dispatch($event, RowEvent::BEFORE_ROW);
            $this->models->add($row);
            $this->eventDispatcher->dispatch($event, RowEvent::AFTER_ROW);
        }
    }

     /**
     * @inheritdoc
     */
    public function getTotalCount($criteria = []): int
    {
        // This Paginator serves total rows
        $this->paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->queryBuilder, $fetchJoinCollection = true);
        $this->totalRows = count($this->paginator);
        
        return $this->totalRows;
    }
}
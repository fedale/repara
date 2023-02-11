<?php
namespace App\Grid\DataProvider;

use App\Grid\Model;
use App\Grid\Serializer\ModelNormalizer;
use App\Grid\Component\Sort;
use App\Grid\Component\Pagination;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    /**
     * Inject dependencies
     *
     * @param Pagination $pagination
     * @param Sort $sort
     */
    public function __construct(Pagination $pagination, Sort $sort){
        $this->pagination = $pagination;
        $this->sort = $sort;
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

    public function prepare(bool $forcePrepare = false)
    {
        /*
        $this->pagination->setTotalCount($this->getTotalCount());
        */
        /*
        $this->queryBuilder
            ->setMaxResults($this->pagination->getPageSize())
            ->setFirstResult($this->pagination->getOffset())
        ;
        */
        
        $sortParams = $this->getSort()->fetchOrders();

        foreach ($sortParams as $fieldName => $sortType) {
            $this->queryBuilder->addOrderBy($fieldName, $sortType);
        }
        $rows = $this->queryBuilder->getQuery()->getResult();
        dump($rows);
        $this->prepareData();
        
        // Have to prepare keys too?
        // $this->prepareKeys();
    }

    private function prepareData(bool $forcePrepare = false)
    {
        // $normalizers = [new ObjectNormalizer(), new ModelNormalizer()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        // $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        
        $normalizers = [new ObjectNormalizer($classMetadataFactory)];
        $serializer = new Serializer($normalizers, []);

        if (!$this->queryBuilder instanceof QueryBuilder) {
            // throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
            throw new \Exception('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $rows = $this->queryBuilder->getQuery()->getResult();
        dump($rows);
        $paginator = new Paginator($this->queryBuilder->getQuery());
        dump($rows);
       
        // $this->models = $serializer->normalize($rows, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'code', 'email', 'username', 'groups' => ['name'], 'profile' => ['firstname', 'lastname']]]);
        // $this->models = $serializer->normalize($rows, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'code', 'email', 'username', 'groups' => ['name'], 'profile' => ['firstname', 'lastname']]]);
        //$result = $serializer->normalize($level1, null, [AbstractObjectNormalizer::ENABLE_MAX_DEPTH => true]);        
        $this->models = $serializer->normalize($paginator, null); //, [AbstractNormalizer::ATTRIBUTES => ['id', 'code', 'email', 'username', 'groups' => ['name'], 'profile' => ['firstname', 'lastname']]]);   
        dump($this->models);
    }

     /**
     * @inheritdoc
     */
    public function getTotalCount($criteria = []): int
    {
        $paginator = new \Doctrine\ORM\Tools\Pagination\Paginator($this->queryBuilder, $fetchJoinCollection = true);
        $totalRows = count($paginator);
        
        return $totalRows;
    }
}
<?php
namespace App\Grid\DataProvider;

use App\Grid\Model;
use App\Grid\Serializer\ModelNormalizer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
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

    public function __construct(private ModelNormalizer $modelNormalizer)
    {
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
        $this->prepareData();
        // Have to prepare keys too?
        // $this->prepareKeys();
    }

    public function prepareData(bool $forcePrepare = false)
    {
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, []);

        if (!$this->queryBuilder instanceof QueryBuilder) {
            // throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
            throw new \Exception('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
        }

        $rows = $this->queryBuilder->getQuery()->getResult();
        // $this->models = $this->modelNormalizer->normalize($rows, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'code', 'email', 'groups' => ['name'], 'profile' => ['firstname', 'lastname']]]);
        $this->models = $serializer->normalize($rows, null, [AbstractNormalizer::ATTRIBUTES => ['id', 'code', 'email', 'groups' => ['name'], 'profile' => ['firstname', 'lastname']]]);
    }

    /*
    public function getModels()
    {
        $this->prepareModels();
        return $this->models;
    }*/


}
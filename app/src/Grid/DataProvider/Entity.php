<?php
namespace App\Grid\DataProvider;

use Doctrine\ORM\EntityManagerInterface;

class Entity implements DataProviderInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    protected $query;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $ormMetadata;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        dump($entityManager);
    }

    public function getSource()
    {
        return;
    }
}
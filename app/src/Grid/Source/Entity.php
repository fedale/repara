<?php
namespace App\Grid\Source;

use Doctrine\ORM\EntityManagerInterface;

class Entity
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

}
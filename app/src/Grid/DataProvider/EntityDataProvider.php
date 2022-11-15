<?php
namespace App\Grid\DataProvider;

use Doctrine\ORM\EntityManagerInterface;

class EntityDataProvider extends AbstractDataProvider
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
    }

    public function prepare(bool $forcePrepare = false)
    {
        return $this->entityManager
            ->getRepository(\App\Entity\Customer\Customer::class)
            ->findAll();
    }
}
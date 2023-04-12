<?php
namespace Fedale\GridviewBundle\Service;

use Fedale\GridviewBundle\Service\QueryBuilder;

class ServiceEntityRepository extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository
{
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return (new QueryBuilder($this->_em))
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }
}
<?php
namespace Fedale\GridviewBundle\Service;

class ServiceEntityRepository extends \Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository
{
    public function like(string $field, string $placeholder)
    {
        dd('dd');
        // return $this->qb->expr()->like('LOWER(p.firstname)', ':fullname');
        return $this->qb->expr()->like($field, $placeholder);
        
    }
}
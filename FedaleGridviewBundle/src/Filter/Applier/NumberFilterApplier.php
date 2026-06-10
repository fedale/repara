<?php

namespace Fedale\GridviewBundle\Filter\Applier;

use Doctrine\ORM\QueryBuilder;

class NumberFilterApplier extends AbstractFilterApplier
{
    public function apply(QueryBuilder $qb, string $dqlField, mixed $rawValue, array $options = []): void
    {
        if (!is_array($rawValue) || $this->isBlank($rawValue)) {
            return;
        }

        $from = $rawValue['from'] ?? null;
        if (is_numeric($from)) {
            $p = $this->uniqueParam();
            $qb->andWhere($qb->expr()->gte($dqlField, ':' . $p));
            $qb->setParameter($p, +$from);
        }

        $to = $rawValue['to'] ?? null;
        if (is_numeric($to)) {
            $p = $this->uniqueParam();
            $qb->andWhere($qb->expr()->lte($dqlField, ':' . $p));
            $qb->setParameter($p, +$to);
        }
    }
}

<?php

namespace Fedale\GridviewBundle\Filter\Applier;

use Doctrine\ORM\QueryBuilder;

class TextFilterApplier extends AbstractFilterApplier
{
    private const OPERATOR_ALIASES = [
        'eq' => 'eq', '==' => 'eq',
        'ieq' => 'ieq', '=' => 'ieq',
        'neq' => 'neq', 'not' => 'neq', '!==' => 'neq', '<>' => 'neq',
        'ineq' => 'ineq', '!=' => 'ineq',
        'gt' => 'gt', '>' => 'gt',
        'gte' => 'gte', '>=' => 'gte',
        'lt' => 'lt', '<' => 'lt',
        'lte' => 'lte', '<=' => 'lte',
        'like' => 'like', '%' => 'like',
        'ilike' => 'ilike',
        'notlike' => 'nlike', 'nlike' => 'nlike', '!%' => 'nlike',
        'notilike' => 'nilike', 'nilike' => 'nilike',
        'startwith' => 'startwith', '-%' => 'startwith',
        'istartwith' => 'istartwith',
        'endwith' => 'endwith', '%-' => 'endwith',
        'in' => 'in',
        'btw' => 'between', 'between' => 'between',
    ];

    public function apply(QueryBuilder $qb, string $dqlField, mixed $rawValue, array $options = []): void
    {
        if ($this->isBlank($rawValue) || !is_scalar($rawValue)) {
            return;
        }

        $defaultOperator = $options['default_operator'] ?? 'ilike';

        [$operator, $term] = $this->parse(trim((string) $rawValue), $defaultOperator);

        if ($term === '') {
            return;
        }

        switch ($operator) {
            case 'eq':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->eq($dqlField, ':' . $p));
                $qb->setParameter($p, $term);
                break;
            case 'ieq':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->eq($qb->expr()->lower($dqlField), ':' . $p));
                $qb->setParameter($p, strtolower($term));
                break;
            case 'neq':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->neq($dqlField, ':' . $p));
                $qb->setParameter($p, $term);
                break;
            case 'ineq':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->neq($qb->expr()->lower($dqlField), ':' . $p));
                $qb->setParameter($p, strtolower($term));
                break;
            case 'gt':
            case 'gte':
            case 'lt':
            case 'lte':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->{$operator}($dqlField, ':' . $p));
                $qb->setParameter($p, $term);
                break;
            case 'like':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->like($dqlField, ':' . $p));
                $qb->setParameter($p, '%' . $term . '%');
                break;
            case 'nlike':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->notLike($dqlField, ':' . $p));
                $qb->setParameter($p, '%' . $term . '%');
                break;
            case 'nilike':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->notLike($qb->expr()->lower($dqlField), ':' . $p));
                $qb->setParameter($p, '%' . strtolower($term) . '%');
                break;
            case 'startwith':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->like($dqlField, ':' . $p));
                $qb->setParameter($p, $term . '%');
                break;
            case 'istartwith':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->like($qb->expr()->lower($dqlField), ':' . $p));
                $qb->setParameter($p, strtolower($term) . '%');
                break;
            case 'endwith':
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->like($dqlField, ':' . $p));
                $qb->setParameter($p, '%' . $term);
                break;
            case 'in':
                $values = array_values(array_filter(array_map('trim', explode(',', $term)), fn ($v) => $v !== ''));
                if ($values === []) {
                    return;
                }
                $p = $this->uniqueParam();
                $qb->andWhere($qb->expr()->in($dqlField, ':' . $p));
                $qb->setParameter($p, $values);
                break;
            case 'between':
                $bounds = preg_split('/\s+and\s+/i', $term);
                if (!is_array($bounds) || count($bounds) !== 2 || trim($bounds[0]) === '' || trim($bounds[1]) === '') {
                    // Malformed range: fall back to treating the whole input as a plain term
                    $this->applyIlike($qb, $dqlField, $term);

                    return;
                }
                $pa = $this->uniqueParam();
                $pb = $this->uniqueParam();
                $qb->andWhere($qb->expr()->between($dqlField, ':' . $pa, ':' . $pb));
                $qb->setParameter($pa, trim($bounds[0]));
                $qb->setParameter($pb, trim($bounds[1]));
                break;
            case 'ilike':
            default:
                $this->applyIlike($qb, $dqlField, $term);
                break;
        }
    }

    /**
     * Splits "<operator> <term>" on the first whitespace only, so terms that
     * contain an operator substring (e.g. "sequence") are never mangled.
     *
     * @return array{0: string, 1: string} [operator, term]
     */
    private function parse(string $input, string $defaultOperator): array
    {
        $spacePos = strpos($input, ' ');

        if ($spacePos !== false) {
            $token = strtolower(substr($input, 0, $spacePos));

            if (isset(self::OPERATOR_ALIASES[$token])) {
                return [self::OPERATOR_ALIASES[$token], trim(substr($input, $spacePos + 1))];
            }
        }

        $normalizedDefault = self::OPERATOR_ALIASES[strtolower($defaultOperator)] ?? 'ilike';

        return [$normalizedDefault, $input];
    }

    private function applyIlike(QueryBuilder $qb, string $dqlField, string $term): void
    {
        $p = $this->uniqueParam();
        $qb->andWhere($qb->expr()->like($qb->expr()->lower($dqlField), ':' . $p));
        $qb->setParameter($p, '%' . strtolower($term) . '%');
    }
}

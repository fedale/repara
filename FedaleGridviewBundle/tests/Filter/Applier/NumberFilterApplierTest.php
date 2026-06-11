<?php

namespace Fedale\GridviewBundle\Tests\Filter\Applier;

use Fedale\GridviewBundle\Filter\Applier\NumberFilterApplier;
use Fedale\GridviewBundle\Tests\Support\CreatesQueryBuilderTrait;
use PHPUnit\Framework\TestCase;

class NumberFilterApplierTest extends TestCase
{
    use CreatesQueryBuilderTrait;

    private NumberFilterApplier $applier;

    protected function setUp(): void
    {
        $this->applier = new NumberFilterApplier();
    }

    public function testFromAndToProduceGteAndLte(): void
    {
        $qb = $this->createTestQueryBuilder();
        $this->applier->apply($qb, 'p.price', ['from' => '10', 'to' => '20.5']);

        $params = $qb->getParameters();
        $this->assertCount(2, $params);
        $this->assertSame(10, $params[0]->getValue());
        $this->assertSame(20.5, $params[1]->getValue());
        $this->assertSame(
            sprintf('p.price >= :%s AND p.price <= :%s', $params[0]->getName(), $params[1]->getName()),
            $this->whereDql($qb)
        );
    }

    public function testZeroIsAValidBound(): void
    {
        $qb = $this->createTestQueryBuilder();
        $this->applier->apply($qb, 'p.price', ['from' => '0', 'to' => '']);

        $params = $qb->getParameters();
        $this->assertCount(1, $params);
        $this->assertSame(0, $params[0]->getValue());
    }

    public function testNonNumericBoundsAreSkipped(): void
    {
        $qb = $this->createTestQueryBuilder();
        $this->applier->apply($qb, 'p.price', ['from' => 'abc', 'to' => '10x']);

        $this->assertNull($qb->getDQLPart('where'));
    }

    public function testBlankOrNonArrayValuesAreSkipped(): void
    {
        $qb = $this->createTestQueryBuilder();
        $this->applier->apply($qb, 'p.price', ['from' => '', 'to' => null]);
        $this->applier->apply($qb, 'p.price', '10');
        $this->applier->apply($qb, 'p.price', null);

        $this->assertNull($qb->getDQLPart('where'));
    }
}

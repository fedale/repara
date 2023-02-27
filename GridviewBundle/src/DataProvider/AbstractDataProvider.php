<?php

namespace Fedale\GridviewBundle\DataProvider;

use Fedale\GridviewBundle\Component\Sort;
use Fedale\GridviewBundle\Component\Pagination;
use Fedale\GridviewBundle\Component\Row;
use Fedale\GridviewBundle\Exception\DataProviderException;
use Doctrine\Common\Collections\Collection;

abstract class AbstractDataProvider implements DataProviderInterface
{
    /**
     * @var Pagination
     */
    protected Pagination $pagination;

    /**
     * @var Sort
     */
    protected Sort $sort;

    /**
     * @param Pagination $pagination
     *
     * @return $this
     */
    public function setPagination(Pagination $pagination): static
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @param Sort $sort
     *
     * @return AbstractDataProvider
     */
    public function setSort(Sort $sort): static
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @return Sort
     */
    public function getSort(): Sort
    {
        return $this->sort;
    }

    /**
     * Get total count of entities.
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return count($this->dataProvider);
    }


    public function getData()
    {
        // $this->prepare();
        return $this->models;
    }
}
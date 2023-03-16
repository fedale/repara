<?php

namespace Fedale\GridviewBundle\DataProvider;

use Fedale\GridviewBundle\Component\Sort;
use Fedale\GridviewBundle\Component\Pagination;
use Fedale\GridviewBundle\Component\Row;
use Fedale\GridviewBundle\Exception\DataProviderException;
use Doctrine\Common\Collections\Collection;
use Fedale\GridviewBundle\Component\PaginationInterface;
use Fedale\GridviewBundle\Component\SortInterface;
use Fedale\GridviewBundle\Form\FilterModelInterface;

abstract class AbstractDataProvider implements DataProviderInterface
{
    /**
     * Array of arrays that carry data on
     */
    private $models;

    private DataProviderInterface $dataProvider;
    
    /**
     * @var PaginationInterface
     */
    protected PaginationInterface $pagination;

    /**
     * @var SortInterface
     */
    protected SortInterface $sort;

    /**
     * @param PaginationInterface $pagination
     *
     * @return $this
     */
    public function setPagination(PaginationInterface $pagination): static
    {
        $this->pagination = $pagination;
        return $this;
    }

    /**
     * @param SortInterace $sort
     *
     * @return AbstractDataProvider
     */
    public function setSort(SortInterface $sort): static
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return PaginationInterface
     */
    public function getPagination(): PaginationInterface
    {
        return $this->pagination;
    }

    /**
     * @return SortInterface
     */
    public function getSort(): SortInterface
    {
        return $this->sort;
    }

     /**
     * @param FilterModelInterace $filterModel
     *
     * @return AbstractDataProvider
     */
    public function setFilterModel(FilterModelInterface $filterModel): static
    {
        $this->filterModel = $filterModel;
        return $this;
    }

    /**
     * @return FilterModelInterface
     */
    public function getFilterModel(): FilterModelInterface
    {
        return $this->filterModel;
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
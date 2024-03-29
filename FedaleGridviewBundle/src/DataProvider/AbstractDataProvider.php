<?php

namespace Fedale\GridviewBundle\DataProvider;

use Fedale\GridviewBundle\Component\PaginationInterface;
use Fedale\GridviewBundle\Component\SortInterface;
use Fedale\GridviewBundle\Service\SearchModelInterface;

abstract class AbstractDataProvider implements DataProviderInterface
{
    private SearchModelInterface $searchModel;

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

    public function setSearchModel(SearchModelInterface $searchModel): static
    {
        $this->searchModel = $searchModel;

        return $this;
    }

    public function getSearchModel(): SearchModelInterface
    {
        return $this->searchModel;
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
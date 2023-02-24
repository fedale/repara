<?php

namespace Fedale\Gridview\DataProvider;

use Fedale\Gridview\Component\Sort;
use Fedale\Gridview\Component\Pagination;
use Fedale\Gridview\Component\Row;
use Fedale\Gridview\Exception\DataProviderException;
use Doctrine\Common\Collections\Collection;

abstract class AbstractDataProvider implements DataProviderInterface
{
    protected Collection $models;

    /**
     * @var string Full class name of target entity.
     */
    protected string $entityName;

    /**
     * @var mixed
     */
    protected \Doctrine\ORM\QueryBuilder $dataProvider;

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

    /**
     * @param string $entityName
     *
     * @return $this
     * @throws DataProviderException
     */
    public function setEntityName(string $entityName): static
    {
        $this->entityName = $entityName;
        return $this;
    }

    /**
     * Get short class name.
     *
     * @return bool|string
     */
    public function getEntityShortName(): bool|string
    {
        if (!$this->entityName || !is_string($this->entityName)) {
            return false;
        }

        return substr(
            $this->entityName,
            strrpos($this->entityName, '\\') + 1
        );
    }

    public function getData()
    {
        // $this->prepare();
        return $this->models;
    }
}
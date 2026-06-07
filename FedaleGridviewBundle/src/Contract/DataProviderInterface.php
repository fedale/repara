<?php

namespace Fedale\GridviewBundle\Contract;

interface DataProviderInterface
{
    public function prepareModels(string|array $models);

    public function getData();

    public function getSort();

    public function getPagination();

    public function applyGlobalSearch(array $fields, string $term): void;
}

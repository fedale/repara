<?php
namespace Fedale\GridviewBundle\Service;

interface SearchFormInterface
{
    public function addFilter(string $name, string $type, array $options);
    public function getModelType();
} 
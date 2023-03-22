<?php
namespace Fedale\GridviewBundle\Service;

use Fedale\GridviewBundle\Form\FilterModel;

class GridviewService
{
    public array $attr = [];

    public function __construct(private FilterModel $filterModel)
    {}

    public function getFilterModel()
    {
        return $this->filterModel;
    }

    public function setAttr(string $key, string $value, $replace = false)
    {
        if (!isset($this->attr[$key])) {
            $this->attr[$key] = $value;
        } else {
            if ($replace) {
                $this->attr[$key] = $value;
            } else {
                $this->attr[$key] .= ' ' . $value;
            }
        }
    }
} 
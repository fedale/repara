<?php
namespace Fedale\GridviewBundle\Service;

use Fedale\GridviewBundle\Form\SearchModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class GridviewService
{
    public array $attr = [];

    private SearchModel $searchModel;

    private Request $request;

    public function __construct(private Environment $twig)
    {}

    public function setSearchModel(SearchModel $searchModel)
    {
        $this->searchModel = $searchModel;
    }

    public function setRequest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function getSearchModel()
    {
        return $this->searchModel;
    }

    public function getEnvironment()
    {
        return $this->twig;
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
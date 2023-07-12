<?php 
namespace Fedale\GridviewBundle\Service;

use Fedale\GridviewBundle\DataProvider\DataProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class SearchModel implements SearchModelInterface
{
    private Request $request;

    private DataProviderInterface $dataProvider;

    public function setRequest(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function setDataProvider(DataProviderInterface $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function search(){}

}
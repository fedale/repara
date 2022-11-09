<?php 
namespace App\Grid;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class GridView {

    private $twig;

    private $columns = [];

    private $entities = [];


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function setColumns($columns) {
        $this->columns = $columns;
    }

    public function setEntities($entities) {
        $this->entities = $entities;
    }

    private function renderTableHeader()
    {

    }

    private function renderTableFooter()
    {
        
    }
        
    public function renderGrid(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters['columns'] = $this->columns;
        $parameters['entities'] = $this->entities;
        $content = $this->twig->render($view, $parameters);

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;

    }
}
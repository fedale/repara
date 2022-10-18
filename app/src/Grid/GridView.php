<?php 
namespace App\Grid;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class GridView {

    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
        
    public function renderGrid(string $view, array $parameters = [], Response $response = null): Response
    {
        $content = $this->twig->render($view, $parameters);

        if (null === $response) {
            $response = new Response();
        }

        $response->setContent($content);

        return $response;

    }
}
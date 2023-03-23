<?php
namespace Fedale\CalendarBundle\Service;

use Twig\Environment;

class CalendarService
{
    public function __construct(private Environment $twig)
    {}

    public function getEnvironment()
    {
        return $this->twig;
    }
} 
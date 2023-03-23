<?php 
namespace Fedale\CalendarBundle\Calendar;

use Fedale\CalendarBundle\DataProvider\DataProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Fedale\CalendarBundle\Service\CalendarService;

class Calendar implements CalendarInterface
{
    private Environment $twig;

    public function __construct(private CalendarService $calendarService)
    {
        $this->twig = $this->calendarService->getEnvironment();
    }
}
<?php
namespace Fedale\CalendarBundle\Calendar;

use Fedale\CalendarBundle\Service\CalendarService;

class CalendarBuilderFactory 
{
    public function __construct(private CalendarService $calendarService) 
    {}

    public function createCalendarBuilder(): CalendarBuilderInterface
    {
        return new CalendarBuilder($this->calendarService);
    }
}
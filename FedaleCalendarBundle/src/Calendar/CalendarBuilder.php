<?php
namespace Fedale\CalendarBundle\Calendar;

use Fedale\CalendarBundle\Service\CalendarService;
use Twig\Environment;

class CalendarBuilder implements CalendarBuilderInterface 
{
    private Calendar $calendar;

    public function __construct(private CalendarService $calendarService)
    {
        $this->reset();
    }

    public function reset()
    {
        $this->calendar = new Calendar($this->calendarService);
    }

    public function renderCalendar(): Calendar
    {
        return $this->calendar;
    }
}
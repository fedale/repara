<?php

namespace App\Twig;

use Exception;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyFilterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('myFilter', [$this, 'myFilter'], ['is_safe' => ['html']])
        ];
    }

    /**
     * 
     */
    public function myFilter($arr): string
    {
        if (count($arr) > 0):
            return 'items';
        else:
            return 'No items';
        endif;
    }
}
<?php

namespace Fedale\GridviewBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OptionsExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('options', [$this, 'renderOptions'], ['is_safe' => ['html']])
        ];
    }

    /**
     */
    public function renderOptions(array $options = []): string
    {
        $str = '';
        foreach ($options as $key => $value) {

            $str .= $key . '="' . $value . '" ';
        }

        return $str;
    }

}
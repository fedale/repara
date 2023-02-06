<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\TwigFilter;

class ApplyFExtension extends AbstractExtension
{
    public function __construct(private Environment $environment) {
    }

    public function getFilters(): array
    {
        return [
        new TwigFilter('makeArrayIfPossible', [$this, 'makeArrayIfPossible']),
        ];
    }

    public function makeArrayIfPossible(string $string): string|array
    {
        $string = trim($string);
        if ($string[0] === '[' && $string[strlen($string) - 1] === ']') {
            $string = substr($string, 1, -1);
            $arr = explode(',', $string);
        }

        return $arr ?? $string;
    }
}
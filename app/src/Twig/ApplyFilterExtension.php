<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\TwigFilter;

class ApplyFilterExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('apply_filter', [$this, 'applyFilter'], [
                    'needs_environment' => true,
                ]
            )
        ];
    }

    public function applyFilter(Environment $environment, $value, $filterName)
    {
        // dump($value, $filterName);
        $twigFilter = $environment->getFilter($filterName);
        
        if (!$twigFilter) {
            return $value;
        }
        [$class, $method] = $twigFilter->getCallable();
        dd($twigFilter->getCallable());
        $f = call_user_func($twigFilter->getCallable(), $environment, $value);
        dump($f);
        return $f;
    }

     // Code adapted from https://stackoverflow.com/a/48606773/2804294 (License: CC BY-SA 3.0)
     public function applyFilterIfExists(Environment $environment, $value, string $filterName, ...$filterArguments)
     {
         $filter = $environment->getFilter($filterName);
         if (false === $filter || null === $filter) {
             return $value;
         }
 
         [$class, $method] = $filter->getCallable();
         if ($class instanceof ExtensionInterface) {
             return $filter->getCallable()($value, ...$filterArguments);
         }
 
         $object = $environment->getRuntime($class);
         if ($object instanceof RuntimeExtensionInterface && method_exists($object, $method)) {
             return $object->$method($value, ...$filterArguments);
         }
 
         return null;
     }
}
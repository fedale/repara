<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\TwigFilter;

class ApplyFilterExtension extends AbstractExtension
{
    public function __construct(private Environment $environment)
    {}

    public function getFilters()
    {
        return [
            new TwigFilter('apply_filter', [$this, 'applyFilter'], [
                  //  'needs_environment' => true,
                  //  'is_safe' => ['html' => true]
                ]
            )
        ];
    }

    public function applyFilter($value, ?string $filterName, ...$filterArguments)
    {
        if (null === $filterName) {
            return $value;
        }
        
        $twigFilter = $this->environment->getFilter($filterName);
        if (false === $twigFilter || null === $twigFilter) {
            return $value;
        }
        
        if ($twigFilter->needsEnvironment()) {
            $f = call_user_func($twigFilter->getCallable(), $this->environment, $value);     
        } else {
            $f = call_user_func($twigFilter->getCallable(), $value);
        }
        
        
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
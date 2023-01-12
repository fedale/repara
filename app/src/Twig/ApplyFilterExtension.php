<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\TwigFilter;

class ApplyFilterExtension extends AbstractExtension
{
    private array|null $options; 

    public function __construct(private Environment $environment)
    {
        $this->options = [
            'title' => ['need_environment' => true],
            'upper' => ['need_environment' => true],
            'lower' => ['need_environment' => true],
            'raw' => ['is_safe' => 'all']
        ];

    }

    public function getFilters()
    {
        return [
            new TwigFilter('apply_filter', [$this, 'applyFilter']
            )
        ];
    }

    public function applyFilters(Environment $env, $value, array $filters = null)
    {
        if (empty($filters)) {
            return $value;
        }

        foreach ($filters as $filter) {
            if (is_array($filter)) {
                $filter_name = array_shift($filter);
                $params      = array_merge([$env, $value], $filter);
            } else {
                $filter_name = $filter;
                $params      = [$env, $value];
            }
            $twigFilter = $env->getFilter($filter_name);
            if (empty($twigFilter)) {
                continue;
            }

            $value = call_user_func_array($twigFilter->getCallable(), $params);
        }

        return $value;
    }


    public function applyFilter($value, ?string $filterName, ...$filterArguments)
    {
        if (null === $filterName) {
            return $value;
        }
        
        $twigFilter = $this->environment->getFilter($filterName);
        dump($twigFilter);
        if (false === $twigFilter || null === $twigFilter) {
            return $value;
        }
        $options = $twigFilter->getOptions();


        $f = call_user_func($twigFilter->getCallable(), $value);
        return $f;

        $f = call_user_func($twigFilter->getCallable(), [$this->getOptions($value), $value]);
        return $f;

        if ($twigFilter->needsEnvironment()) {
            $f = call_user_func($twigFilter->getCallable(), $this->environment, $value);
        } else {
            $f = call_user_func($twigFilter->getCallable(), $value);
        }
        
        
        return $f;
    }

    private function getOptions($key = null) {
        if (null === $key) {
            return [];
        }

        $options = [
            'title' => ['need_environment' => true],
            'upper' => ['need_environment' => true],
            'lower' => ['need_environment' => true],
            'raw' => ['is_safe' => 'all']
        ];

        return $options[$key];
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
<?php

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\TwigFilter;

class ApplyFilterExtension extends AbstractExtension
{
    public function __construct(private Environment $environment) {
    }

    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('rot13', [$this, 'rot13']),
        ];
        
        return [
            new \Twig\TwigFunction('call_filter', function($input, $filter, ...$args) {
                if (null === $filter) { return $input; }
                $options = $this->getFilterOptions($filter);
                dump($input, $filter, $options);
                return $this->environment->getFilter($filter)->getCallable()($input, ...$args);
            }, ['is_safe' => ['all']])
        ];
    }

    private function getFilterOptions($key = null) {
        $options = [
            'raw' => ['is_safe' => ['all']]
        ];

        if (null === $key) {
            return $options;
        }
        
        return $options[$key];
    }

    public function getFilters()
    {
        return [
            // new TwigFilter('apply_filter', [$this, 'applyFilter2'], ['needs_environment' => true, 'needs_context' => true])
            new TwigFilter('apply_filter', [$this, 'applyFilter'], ['needs_environment' => true])
        ];
    }

    public function applyFilters(Environment $env, $value, $filters = null)
    {
        if (empty($filters)) {
            return $value;
        }
        //$filter_name = $filter;
        $params      = [$env, $value];
        
        $twigFilter = $env->getFilter($filters);
        
        $value = call_user_func_array($twigFilter->getCallable(), $params);

        return $value;

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

    public function applyFilter3($value, ?string $filterName, ...$filterArguments)
    {
        // dump($filterArguments);
        if (null === $filterName) {
            return $value;
        }
        
        $twigFilter = $this->environment->getFilter($filterName);
    }

    public function applyFilter2(Environment $env, $context, $value, $filters)
    {
        return $value;
        // dump($env, $context, $value, $filters);
        // dump($env, $context, $value, $filters);
        $name = 'apply_filter_' . md5($filters);

        $template = sprintf('{{ %s|%s }}', $name, $filters);
        dump($name, $template);
        //dd();
        $template = $this->environment->load($template);

        $context[$name] = $value;

        return $template->render($context);
    }

    public function applyFilters_BAK(Environment $env, $value, array $filters = null)
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
        // dump($filterArguments);
        if (null === $filterName) {
            return $value;
        }
        
        $twigFilter = $this->environment->getFilter($filterName);

        dump($twigFilter);
        
        if (false === $twigFilter || null === $twigFilter) {
            return $value;
        }
        
        // $f = call_user_func($twigFilter->getCallable(), $value);
        // return $f;

        // $f = call_user_func($twigFilter->getCallable(), [$this->getOptions($value), $value]);
        // return $f;

        if ($twigFilter->needsEnvironment()) {
            $f = call_user_func($twigFilter->getCallable(), $this->environment, $value);
        } else {
            $f = call_user_func($twigFilter->getCallable(), $value, implode($filterArguments));
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
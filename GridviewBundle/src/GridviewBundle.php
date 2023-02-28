<?php 

namespace Fedale\GridviewBundle;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

/**
 * Gridview Bundle
 */
class GridviewBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        // load an XML, PHP or Yaml file
        $containerConfigurator->import('../config/services.xml');
        $containerConfigurator->services()
            ->set('\Twig\Extension\StringLoaderExtension', Twig\Extension\StringLoaderExtension::class)
            ;
        // dd($containerConfigurator->services());
        // $containerConfigurator->services()
        //     ->set('\Twig\Extension\StringLoaderExtension', Twig\Extension\StringLoaderExtension::class)
        // ;
        // you can also add or replace parameters and services
        /*
        $containerConfigurator->parameters()
            ->set('acme_hello.phrase', $config['phrase'])
        ;

        if ($config['scream']) {
            $containerConfigurator->services()
                ->get('acme_hello.printer')
                    ->class(ScreamingPrinter::class)
            ;
        }*/
    }
}
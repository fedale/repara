<?php 

namespace Fedale\GridviewBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
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
//  dd($config);
        $containerConfigurator->services()
            ->set('gridview.template', $config['template'])
        
            // ->set('gridview.r')
        ;
        
        $containerConfigurator->parameters()
            ->set('gridview.attr', $config['attr'])
        ;

        /*
        if ($config['scream']) {
            $containerConfigurator->services()
                ->get('acme_hello.printer')
                    ->class(ScreamingPrinter::class)
            ;
        }*/
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->scalarNode('template')
                    ->defaultValue('fedale')
                ->end()
                ->arrayNode('attr')
                    ->children()
                        ->scalarNode('class')->end()
                        ->scalarNode('id')->end()
                        ->scalarNode('data-custom')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
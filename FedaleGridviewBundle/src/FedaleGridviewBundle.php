<?php 

namespace Fedale\GridviewBundle;

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

/**
 * Gridview Bundle
 */
class FedaleGridviewBundle extends AbstractBundle
{
    //protected string $extensionAlias = 'gridview'; 

    public function loadExtension(array $config, ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void
    {
        // load an XML, PHP or Yaml file
        $containerConfigurator->import('../config/services.xml');
        $containerConfigurator->import('../config/columns.xml');

        // $containerConfigurator->services()
        //     ->set('gridview.template', $config['template'])        
        // ;
        // $containerConfigurator->parameters()
        //     ->set('gridview.attr', $config['attr'])
        // ;
       
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

//     public function build(ContainerBuilder $container): void
//   {
//       $container->addCompilerPass($this);
//       //$container->addCompilerPass(new RegisterServiceSubscribersPass());
//   }

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
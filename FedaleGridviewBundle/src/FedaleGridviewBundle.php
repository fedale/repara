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
        $containerConfigurator->import('../config/services.xml');
        $containerConfigurator->import('../config/columns.xml');

        $containerConfigurator->parameters()
            ->set('fedale_gridview.config', $config);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->scalarNode('template')->defaultValue('fedale')->end()
                ->arrayNode('defaults')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('caption')->defaultNull()->end()
                                ->scalarNode('emptyText')->defaultValue('No records found')->end()
                                ->booleanNode('showHeader')->defaultTrue()->end()
                                ->booleanNode('showFooter')->defaultTrue()->end()
                                ->booleanNode('useTurbo')->defaultTrue()->end()
                                ->arrayNode('globalSearch')
                                    ->scalarPrototype()->end()
                                    ->defaultValue([])
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('attributes')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->defaultNull()->end()
                                ->arrayNode('row')->normalizeKeys(false)->variablePrototype()->end()->end()
                                ->arrayNode('container')->normalizeKeys(false)->variablePrototype()->end()->end()
                                ->arrayNode('header')->normalizeKeys(false)->variablePrototype()->end()->end()
                                ->arrayNode('filter')->normalizeKeys(false)->variablePrototype()->end()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('gridviews')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->arrayNode('options')
                                ->children()
                                    ->scalarNode('caption')->end()
                                    ->scalarNode('emptyText')->end()
                                    ->booleanNode('showHeader')->end()
                                    ->booleanNode('showFooter')->end()
                                    ->booleanNode('useTurbo')->end()
                                    ->arrayNode('globalSearch')
                                        ->scalarPrototype()->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('attributes')
                                ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('class')->defaultNull()->end()
                                    ->arrayNode('row')->normalizeKeys(false)->variablePrototype()->end()->end()
                                    ->arrayNode('container')->normalizeKeys(false)->variablePrototype()->end()->end()
                                    ->arrayNode('header')->normalizeKeys(false)->variablePrototype()->end()->end()
                                    ->arrayNode('filter')->normalizeKeys(false)->variablePrototype()->end()->end()
                                ->end()
                            ->end()
                        ->end()
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
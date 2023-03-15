<?php 
namespace Fedale\GridviewBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class GridviewExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $containerBuilder)
    {
        return;
        $loader = new XmlFileLoader($containerBuilder, new FileLocator(dirname(__DIR__).'/../config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /*
        $definition = $containerBuilder->getDefinition('acme.social.twitter_client');
        $definition->replaceArgument(0, $config['twitter']['client_id']);
        $definition->replaceArgument(1, $config['twitter']['client_secret']);
        */
    }
}
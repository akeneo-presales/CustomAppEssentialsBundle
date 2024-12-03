<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('akeneo_event_platform');

        $rootNode = $treeBuilder->getRootNode();
        $rootNode
            ->children()
            ->scalarNode('tenant_class')->defaultValue('App\Entity\Tenant')->end()
            ->end()
        ;
        return $treeBuilder;
    }
}

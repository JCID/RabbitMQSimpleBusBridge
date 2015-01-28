<?php

namespace Jcid\RabbitMQBridge\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $treeBuilder->root("jcid_rabbit_mq_bridge")
            ->children()
                ->scalarNode("debug")->defaultFalse()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}

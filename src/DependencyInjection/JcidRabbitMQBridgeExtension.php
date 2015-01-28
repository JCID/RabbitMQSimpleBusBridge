<?php

namespace Jcid\RabbitMQBridge\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class JcidRabbitMQBridgeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__."/../Resources/config"));
        $loader->load("handler.xml");

        if ($config["debug"] === true && $container->hasDefinition("jcid.rabbitmq.bus")) {
            $container->removeDefinition("jcid.rabbitmq.bus");
        }
    }
}

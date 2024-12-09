<?php

namespace AkeneoPresales\CustomAppEssentialsBundle\DependencyInjection;

use AkeneoPresales\CustomAppEssentialsBundle\Entity\TenantInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AkeneoPresalesCustomAppEssentialsExtension  extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $tenantClass = $config['tenant_class'];

        foreach (get_declared_classes() as $className) {
            if (in_array(TenantInterface::class, class_implements($className))) {
                $tenantClass = $className;
                break;
            }
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $definition = $container->getDefinition('akeneo_presales.service.get_tenant_service');
        $definition->setArgument(0, $tenantClass);
        $definition->setArgument(1, new Reference('doctrine.orm.entity_manager'));

        $definition = $container->getDefinition('akeneo_presales.service.tenant_service');
        $definition->setArgument(0, $tenantClass);
        $definition->setArgument(1, new Reference('doctrine.orm.entity_manager'));
        $definition->setArgument(2, new Reference('http_client'));
        $definition->setArgument(3, new Reference('akeneo_presales.pimapi.client_from_tenant_factory'));

    }


    public function getAlias(): string
    {
        return 'akeneo_presales_custom_app_essentials';
    }

    public function prepend(ContainerBuilder $container)
    {
        $phpLoader = new PhpFileLoader($container, new FileLocator(\dirname(__DIR__).'/Resources/config'));
        $phpLoader->load('eight_points_guzzle.php');
        $phpLoader->load('idci_graphql_client.php');
    }
}

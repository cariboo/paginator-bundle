<?php

namespace Cariboo\SimplePaginatorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * CaribooSimplePaginator Dependency Injection Extension
 *
 * Class that defines the Dependency Injection Extension to expose the bundle's semantic configuration
 * @package CaribooSimplePaginatorBundle
 * @subpackage DependencyInjection
 */
class CaribooSimplePaginatorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // registering services
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}

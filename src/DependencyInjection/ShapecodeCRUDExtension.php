<?php

namespace Shapecode\Bundle\CRUDBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * Class ShapecodeCRUDExtension
 *
 * @package Shapecode\Bundle\CRUDBundle\DependencyInjection
 * @author  Nikita Loges
 */
class ShapecodeCRUDExtension extends ConfigurableExtension implements PrependExtensionInterface
{

    /**
     * {@inheritdoc}
     */
    public function loadInternal(array $config, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('shapecode_crud.managers', $config['managers']);
    }

    /**
     * @inheritDoc
     */
    public function prepend(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('shapecode_crud', [
            'managers' => [
                'default' => []
            ]
        ]);
    }
}

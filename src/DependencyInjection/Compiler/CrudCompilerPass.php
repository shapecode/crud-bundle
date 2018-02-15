<?php

namespace Shapecode\Bundle\CRUDBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CrudCompilerPass
 *
 * @package Shapecode\Bundle\CRUDBundle\DependencyInjection\Compiler
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class CrudCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('shapecode_crud.crud_manager');
        $tags = $container->findTaggedServiceIds('shapecode_crud.crud');

        foreach ($tags as $id => $configs) {
            $definition->addMethodCall('addCrud', [new Reference($id)]);
        }
    }

}

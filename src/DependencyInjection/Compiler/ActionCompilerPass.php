<?php

namespace Shapecode\Bundle\CRUDBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ActionCompilerPass
 *
 * @package Shapecode\Bundle\CRUDBundle\DependencyInjection\Compiler
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class ActionCompilerPass implements CompilerPassInterface
{

    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('shapecode_crud.action_manager');
        $tags = $container->findTaggedServiceIds('shapecode_crud.action');

        foreach ($tags as $id => $configs) {
            $actionDefiniton = $container->getDefinition($id);
            $actionDefiniton->setShared(false);

            $definition->addMethodCall('addAction', [$id]);
        }
    }

}

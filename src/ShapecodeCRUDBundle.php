<?php

namespace Shapecode\Bundle\CRUDBundle;

use Shapecode\Bundle\CRUDBundle\DependencyInjection\Compiler\ActionCompilerPass;
use Shapecode\Bundle\CRUDBundle\DependencyInjection\Compiler\CrudCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ShapecodeCRUDBundle
 *
 * @package Shapecode\Bundle\CRUDBundle
 * @author  Nikita Loges
 */
class ShapecodeCRUDBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ActionCompilerPass());
        $container->addCompilerPass(new CrudCompilerPass());
    }
}

<?php

namespace Shapecode\Bundle\CRUDBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration
 *
 * @package Shapecode\Bundle\CRUDBundle\DependencyInjection
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('shapecode_crud');

        $rootNode
            ->fixXmlConfig('manager')
            ->children()
                ->arrayNode('managers')
                    ->useAttributeAsKey('name')
                    ->defaultValue([
                        'default' => []
                    ])
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('layout_template')->defaultValue('@ShapecodeCRUD/layout.html.twig')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}

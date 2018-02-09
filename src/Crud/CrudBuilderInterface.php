<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

/**
 * Interface CrudBuilderInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
interface CrudBuilderInterface
{

    /**
     * @param       $name
     * @param       $class
     * @param array $options
     */
    public function add($name, $class, $options = []);

    /**
     * @param $name
     *
     * @return ActionConfiguration
     */
    public function get($name);
}

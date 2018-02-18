<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

/**
 * Interface CrudBuilderInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
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

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * @param $name
     *
     * @return ActionConfiguration
     */
    public function remove($name);
}

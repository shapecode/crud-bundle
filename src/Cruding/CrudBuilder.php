<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

/**
 * Class CrudBuilder
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class CrudBuilder implements CrudBuilderInterface
{

    /** @var ActionConfiguration */
    protected $configurations;

    /**
     */
    public function __construct()
    {
        $this->configurations = [];
    }

    /**
     * @inheritdoc
     */
    public function add($name, $class, $options = [])
    {
        $this->configurations[$name] = new ActionConfiguration($name, $class, $options);
    }

    /**
     * @param $name
     *
     * @return ActionConfiguration
     */
    public function get($name)
    {
        return $this->configurations[$name];
    }

    /**
     * @param $name
     */
    public function remove($name)
    {
        unset($this->configurations[$name]);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return isset($this->configurations[$name]);
    }

    /**
     * @return ActionConfiguration[]
     */
    public function all()
    {
        return $this->configurations;
    }
}

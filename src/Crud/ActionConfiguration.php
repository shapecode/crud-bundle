<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

/**
 * Class ActionConfiguration
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
class ActionConfiguration
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $className;

    /** @var array */
    protected $options = [];

    /**
     * @param string $name
     * @param string $className
     * @param array  $options
     */
    public function __construct($name, $className, array $options = [])
    {
        $this->name = $name;
        $this->className = $className;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getOption($name)
    {
        return $this->options[$name];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}

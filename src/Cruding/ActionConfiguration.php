<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

/**
 * Class ActionConfiguration
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class ActionConfiguration implements ActionConfigurationInterface
{

    /** @var string */
    protected $name;

    /** @var string */
    protected $className;

    /** @var array */
    protected $options = [];

    /** @var array */
    protected $permissions = [];

    /**
     * @param       $name
     * @param       $className
     * @param array $options
     * @param array $permissions
     */
    public function __construct($name, $className, array $options = [], array $permissions = [])
    {
        $this->name = $name;
        $this->className = $className;
        $this->options = $options;
        $this->permissions = $permissions;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @inheritdoc
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @inheritdoc
     */
    public function hasOption($name)
    {
        return isset($this->options[$name]);
    }

    /**
     * @inheritdoc
     */
    public function getOption($name)
    {
        return $this->options[$name];
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    /**
     * @inheritdoc
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}

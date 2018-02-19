<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Symfony\Component\OptionsResolver\OptionsResolver;

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

    /** @var OptionsResolver|null */
    protected $resolver;

    /** @var array|null */
    protected $resolved;

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

    /**
     * @return null|OptionsResolver
     */
    public function getResolver()
    {
        if (is_null($this->resolver)) {
            $resolver = new OptionsResolver();
            call_user_func_array([$this->getClassName(), 'configureOptions'], [$resolver]);

            $this->resolver = $resolver;
        }

        return $this->resolver;
    }

    /**
     * @return array|null
     */
    public function getResolved()
    {
        if (is_null($this->resolved)) {
            $this->resolved = $this->getResolver()->resolve($this->getOptions());
        }

        return $this->resolved;
    }
}

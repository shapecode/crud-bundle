<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

/**
 * Interface ActionConfigurationInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
interface ActionConfigurationInterface
{

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getClassName();

    /**
     * @param string $className
     */
    public function setClassName($className);

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasOption($name);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getOption($name);

    /**
     * @return array
     */
    public function getOptions();

    /**
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * @param $name
     * @param $value
     */
    public function setOption($name, $value);

    /**
     * @return array
     */
    public function getPermissions();
}

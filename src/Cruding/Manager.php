<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Doctrine\Common\Collections\ArrayCollection;
use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Class Manager
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class Manager implements ManagerInterface
{

    /** @var string */
    protected $name;

    /** @var array */
    protected $options;

    /** @var ArrayCollection|AbstractCrudInterface[] */
    protected $cruds;

    /**
     * @param       $name
     * @param array $options
     */
    public function __construct($name, array $options = [])
    {
        $this->name = $name;
        $this->options = $options;
        $this->cruds = new ArrayCollection();
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
    public function addCrud(AbstractCrudInterface $admin)
    {
        $this->cruds[$admin->getName()] = $admin;
    }

    /**
     * @inheritdoc
     */
    public function getCrud($name)
    {
        return $this->cruds[$name];
    }

    /**
     * @inheritdoc
     */
    public function getCruds()
    {
        return $this->cruds;
    }

    /**
     * @inheritdoc
     */
    public function getOption($name)
    {
        return $this->options[$name];
    }
}

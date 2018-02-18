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

    /** @var ArrayCollection|AbstractCrudInterface[] */
    protected $cruds;

    /**
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->cruds = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param AbstractCrudInterface $admin
     */
    public function addCrud(AbstractCrudInterface $admin)
    {
        $this->cruds[$admin->getName()] = $admin;
    }

    /**
     * @param $name
     *
     * @return AbstractCrudInterface
     */
    public function getCrud($name)
    {
        return $this->cruds[$name];
    }

    /**
     * @return ArrayCollection|AbstractCrudInterface[]
     */
    public function getCruds()
    {
        return $this->cruds;
    }
}

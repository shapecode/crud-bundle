<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class CrudManager
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
class CrudManager implements CrudManagerInterface
{

    /** @var ArrayCollection|AbstractCrudInterface[] */
    protected $cruds;

    /**
     */
    public function __construct()
    {
        $this->cruds = new ArrayCollection();
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

<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface CrudManagerInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
interface CrudManagerInterface
{

    /**
     * @param AbstractCrudInterface $admin
     */
    public function addCrud(AbstractCrudInterface $admin);

    /**
     * @param $name
     *
     * @return AbstractCrudInterface
     */
    public function getCrud($name);

    /**
     * @return ArrayCollection|AbstractCrudInterface[]
     */
    public function getCruds();
}

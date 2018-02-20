<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Doctrine\Common\Collections\ArrayCollection;
use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Interface ManagerInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
interface ManagerInterface
{

    /**
     * @return string
     */
    public function getName();

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

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getOption($name);
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Factory;

use Shapecode\Bundle\CRUDBundle\Cruding\ManagerInterface;

/**
 * Interface ManagerFactoryInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Factory
 * @author  Nikita Loges
 * @company tenolo GbR
 */
interface ManagerFactoryInterface
{

    /**
     * @param $name
     *
     * @return ManagerInterface
     */
    public function create($name);
}

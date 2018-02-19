<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Interface CrudHelperInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
interface CrudHelperInterface
{

    /**
     * @param $name
     *
     * @return boolean
     */
    public function hasAction($name);

    /**
     * @param $name
     *
     * @return boolean
     */
    public function hasPermission($name);

    /**
     * @param       $name
     * @param array $params
     *
     * @return string
     */
    public function generateUrl($name, array $params = []);

    /**
     * @param $name
     *
     * @return ActionConfiguration
     */
    public function getAction($name);

    /**
     * @return ManagerInterface
     */
    public function getManager();

    /**
     * @return AbstractCrudInterface
     */
    public function getCrud();
}

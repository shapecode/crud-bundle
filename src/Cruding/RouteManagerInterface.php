<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Interface RouteManagerInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Crudinging
 * @author  Nikita Loges
 */
interface RouteManagerInterface
{

    /**
     * @param ActionConfiguration   $action
     * @param ManagerInterface      $manager
     * @param AbstractCrudInterface $crud
     *
     * @return string
     */
    public function generateRouteName(ActionConfiguration $action, ManagerInterface $manager, AbstractCrudInterface $crud);

    /**
     * @param ActionConfiguration   $action
     * @param ManagerInterface      $manager
     * @param AbstractCrudInterface $crud
     * @param array                 $params
     *
     * @return string
     */
    public function generateRouteUrl(ActionConfiguration $action, ManagerInterface $manager, AbstractCrudInterface $crud, array $params = []);
}

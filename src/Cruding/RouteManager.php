<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class RouteManager
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class RouteManager implements RouteManagerInterface
{

    /** @var UrlGeneratorInterface */
    protected $router;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param ActionConfiguration   $action
     * @param ManagerInterface      $manager
     * @param AbstractCrudInterface $crud
     *
     * @return string
     */
    public function generateRouteName(ActionConfiguration $action, ManagerInterface $manager, AbstractCrudInterface $crud)
    {
        $routeName = 'shapecode_crud';
        $routeName .= '_' . $manager->getName();
        $routeName .= '_' . $crud->getName();
        $routeName .= '_' . $action->getName();

        return $routeName;
    }

    /**
     * @param ActionConfiguration   $action
     * @param ManagerInterface      $manager
     * @param AbstractCrudInterface $crud
     * @param array                 $params
     *
     * @return string
     */
    public function generateRouteUrl(ActionConfiguration $action, ManagerInterface $manager, AbstractCrudInterface $crud, array $params = [])
    {
        $routeName = $this->generateRouteName($action, $manager, $crud);

        $actionClassName = $action->getClassName();

        $params = call_user_func_array([$actionClassName, 'getRouteFormattedParams'], [$params, $action->getResolved()]);

        return $this->router->generate($routeName, $params);
    }
}

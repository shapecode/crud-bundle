<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Class CrudHelper
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class CrudHelper implements CrudHelperInterface
{

    /** @var CrudBuilderInterface */
    protected $builder;

    /** @var ManagerInterface */
    protected $manager;

    /** @var AbstractCrudInterface */
    protected $crud;

    /** @var RouteManagerInterface */
    protected $routeManager;

    /**
     * @param RouteManagerInterface $routeManager
     * @param CrudBuilderInterface  $builder
     * @param ManagerInterface      $manager
     * @param AbstractCrudInterface $crud
     */
    public function __construct(RouteManagerInterface $routeManager, CrudBuilderInterface $builder, ManagerInterface $manager, AbstractCrudInterface $crud)
    {
        $this->builder = $builder;
        $this->manager = $manager;
        $this->crud = $crud;
        $this->routeManager = $routeManager;
    }

    /**
     * @inheritdoc
     */
    public function hasAction($name)
    {
        return $this->builder->has($name);
    }

    /**
     * @inheritdoc
     */
    public function hasPermission($name)
    {
        if (!$this->hasAction($name)) {
            return false;
        }

        $configuration = $this->getAction($name);
        $permissions = $configuration->getPermissions();

//        if($permissions) {
//
//        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function generateUrl($name, array $params = [])
    {
        $action = $this->getAction($name);

        return $this->routeManager->generateRouteUrl($action, $this->manager, $this->crud, $params);
    }

    /**
     * @inheritdoc
     */
    public function getAction($name)
    {
        return $this->builder->get($name);
    }

    /**
     * @inheritdoc
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * @inheritdoc
     */
    public function getCrud()
    {
        return $this->crud;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function getManagerOption($name)
    {
        return $this->manager->getOption($name);
    }
}

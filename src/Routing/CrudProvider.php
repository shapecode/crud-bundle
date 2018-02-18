<?php

namespace Shapecode\Bundle\CRUDBundle\Routing;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;
use Shapecode\Bundle\CRUDBundle\Crud\ActionConfiguration;
use Shapecode\Bundle\CRUDBundle\Crud\CrudBuilder;
use Shapecode\Bundle\CRUDBundle\Crud\CrudManagerInterface;
use Symfony\Cmf\Component\Routing\RouteProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class CrudProvider
 *
 * @package Shapecode\Bundle\CRUDBundle\Routing
 * @author  Nikita Loges
 */
class CrudProvider implements RouteProviderInterface
{

    /** @var CrudManagerInterface */
    protected $crudManager;

    /** @var RouteCollection */
    protected $collection;

    /**
     * @param CrudManagerInterface $crudManager
     */
    public function __construct(CrudManagerInterface $crudManager)
    {
        $this->crudManager = $crudManager;
    }

    /**
     * @inheritDoc
     */
    public function getRouteCollectionForRequest(Request $request)
    {
        return $this->getRouteCollection();
    }

    /**
     * @inheritDoc
     */
    public function getRouteByName($name)
    {
        return $this->getRouteCollection()->get($name);
    }

    /**
     * @inheritDoc
     */
    public function getRoutesByNames($names)
    {
        return $this->getRouteCollection()->all();
    }

    /**
     * @return RouteCollection
     */
    public function getRouteCollection()
    {
        if (is_null($this->collection)) {
            $this->init();
        }

        return $this->collection;
    }

    /**
     *
     */
    public function init()
    {
        $routes = new RouteCollection();
        $cruds = $this->crudManager->getCruds();

        foreach ($cruds as $crud) {
            $scenarioRoutes = $this->load($crud);

            $routes->addCollection($scenarioRoutes);
        }

        $this->collection = $routes;
    }

    /**
     * @param AbstractCrudInterface $crud
     *
     * @return RouteCollection
     */
    protected function load(AbstractCrudInterface $crud)
    {
        $routes = new RouteCollection();
        $builder = new CrudBuilder();
        $resolver = new OptionsResolver();

        $crud->configureOptions($resolver);
        $crud->buildCrud($builder, $resolver->resolve());

        foreach ($builder->all() as $configuration) {
            $name = 'shapecode_crud_' . $crud->getName() . '_' . $configuration->getName();
            $routes->add($name, $this->getActionRoute($crud, $configuration));
        }

        return $routes;
    }

    /**
     * @param AbstractCrudInterface $crud
     * @param ActionConfiguration   $configuration
     *
     * @return Route
     */
    protected function getActionRoute(AbstractCrudInterface $crud, ActionConfiguration $configuration)
    {
        $name = $configuration->getName();

        $defaults = [
            '_controller' => 'ShapecodeCRUDBundle:Crud:execute',
        ];

        $path = $crud->getRoute();

        $actionClassName = $configuration->getClassName();
        $path .= call_user_func_array([$actionClassName, 'getRoute'], []);

        $route = new Route($path, $defaults);
        $route->setPath($route->getPath());

        $route->addDefaults([
            '_crud_name'   => $crud->getName(),
            '_action_name' => $name,
        ]);

        $route->addOptions([
            'expose' => true
        ]);

        return $route;
    }
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Routing;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;
use Shapecode\Bundle\CRUDBundle\Cruding\ActionConfigurationInterface;
use Shapecode\Bundle\CRUDBundle\Cruding\CrudBuilder;
use Shapecode\Bundle\CRUDBundle\Cruding\ManagerInterface;
use Shapecode\Bundle\CRUDBundle\Cruding\OrganizerInterface;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class CrudLoader
 *
 * @package Shapecode\Bundle\CRUDBundle\Routing
 * @author  Nikita Loges
 */
class CrudLoader extends Loader
{

    /** @var OrganizerInterface */
    protected $organizer;

    /**
     * @param OrganizerInterface $organizer
     */
    public function __construct(OrganizerInterface $organizer)
    {
        $this->organizer = $organizer;
    }

    /**
     * @inheritdoc
     */
    public function load($resource, $type = null)
    {
        $routes = new RouteCollection();

        $manager = $this->organizer->getManager($resource);
        $cruds = $manager->getCruds();

        foreach ($cruds as $crud) {
            $scenarioRoutes = $this->buildRoute($crud, $manager);

            $routes->addCollection($scenarioRoutes);
        }

        return $routes;
    }

    /**
     * @param AbstractCrudInterface $crud
     * @param ManagerInterface      $manager
     *
     * @return RouteCollection
     */
    protected function buildRoute(AbstractCrudInterface $crud, ManagerInterface $manager)
    {
        $routes = new RouteCollection();
        $builder = new CrudBuilder();
        $resolver = new OptionsResolver();

        $crud->configureOptions($resolver);
        $crud->buildCrud($builder, $resolver->resolve());

        foreach ($builder->all() as $configuration) {
            $name = 'shapecode_crud_' . $manager->getName() . '_' . $crud->getName() . '_' . $configuration->getName();
            $routes->add($name, $this->getActionRoute($crud, $configuration, $manager));
        }

        return $routes;
    }

    /**
     * @param AbstractCrudInterface        $crud
     * @param ActionConfigurationInterface $configuration
     * @param ManagerInterface             $manager
     *
     * @return Route
     */
    protected function getActionRoute(AbstractCrudInterface $crud, ActionConfigurationInterface $configuration, ManagerInterface $manager)
    {
        $name = $configuration->getName();

        $defaults = [
            '_controller' => 'shapecode_crud.controller:executeAction',
        ];

        $path = $crud->getRoute();

        $actionClassName = $configuration->getClassName();
        $path .= call_user_func_array([$actionClassName, 'getRoute'], []);

        $route = new Route($path, $defaults);
        $route->setPath($route->getPath());

        $route->addDefaults([
            '_crud_manager' => $manager->getName(),
            '_crud_name'    => $crud->getName(),
            '_action_name'  => $name,
        ]);

        $route->addOptions([
            'expose' => true
        ]);

        return $route;
    }

    /**
     * @inheritdoc
     */
    public function supports($resource, $type = null)
    {
        return 'crud' === $type;
    }
}

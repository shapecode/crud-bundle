<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Shapecode\Bundle\CRUDBundle\Action\ActionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class Execution
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class Execution implements ExecutionInterface
{

    /** @var OrganizerInterface */
    protected $organizer;

    /** @var ActionManagerInterface */
    protected $actionManager;

    /** @var RouteManagerInterface */
    protected $routeManager;

    /** @var RequestStack */
    protected $requestStack;

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param OrganizerInterface     $organizer
     * @param ActionManagerInterface $actionManager
     * @param RouteManagerInterface  $routeManager
     * @param RequestStack           $requestStack
     * @param ContainerInterface     $container
     */
    public function __construct(
        OrganizerInterface $organizer,
        ActionManagerInterface $actionManager,
        RouteManagerInterface $routeManager,
        RequestStack $requestStack,
        ContainerInterface $container)
    {
        $this->organizer = $organizer;
        $this->actionManager = $actionManager;
        $this->routeManager = $routeManager;
        $this->requestStack = $requestStack;
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function execute(Request $request)
    {
        $crudManagerName = $request->get('_crud_manager');
        $crudName = $request->get('_crud_name');
        $actionName = $request->get('_action_name');

        $crudBuilder = new CrudBuilder();
        $crudResolver = new OptionsResolver();
        $crudManager = $this->organizer->getManager($crudManagerName);
        $crud = $crudManager->getCrud($crudName);

        $crud->configureOptions($crudResolver);
        $crudOptions = $crudResolver->resolve();
        $crud->buildCrud($crudBuilder, $crudOptions);

        $crudHelper = new CrudHelper($this->routeManager, $crudBuilder, $crudManager, $crud);

        $configuration = $crudBuilder->get($actionName);

        $className = $configuration->getClassName();
        $options = $configuration->getOptions();

        $resolver = new OptionsResolver();
        call_user_func_array([$className, 'configureOptions'], [$resolver]);

        $resolved = $resolver->resolve($options);

        /** @var ActionInterface $action */
        $action = $this->actionManager->getAction($className);
        $action->setCrudHelper($crudHelper);
        $action->setOptions($resolved);
        $action->setRequestStack($this->requestStack);
        $action->setContainer($this->container);

        $action->execute();

        return $action->getResponse();
    }
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Controller;

use Shapecode\Bundle\CRUDBundle\Action\ActionInterface;
use Shapecode\Bundle\CRUDBundle\Crud\AdminBuilderInterface;
use Shapecode\Bundle\CRUDBundle\Crud\CrudBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CrudController
 *
 * @package Shapecode\Bundle\CRUDBundle\Controller
 * @author  Nikita Loges
 */
class CrudController extends Controller
{

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeAction(Request $request)
    {
        $crudName = $request->get('_crud_name');
        $actionName = $request->get('_action_name');

        $crudBuilder = new CrudBuilder();
        $crudResolver = new OptionsResolver();
        $crud = $this->get('shapecode_crud.crud_manager')->getCrud($crudName);

        $crud->configureOptions($crudResolver);
        $crudOptions = $crudResolver->resolve();
        $crud->buildCrud($crudBuilder, $crudOptions);

        $configuration = $crudBuilder->get($actionName);

        $className = $configuration->getClassName();
        $options = $configuration->getOptions();

        $resolver = new OptionsResolver();
        call_user_func_array([$className, 'configureOptions'], [$resolver]);

        $resolved = $resolver->resolve($options);

        /** @var ActionInterface $action */
        $action = $this->get('shapecode_crud.action_manager')->getAction($className);
        $action->setOptions($resolved);
        $action->setRequestStack($this->container->get('request_stack'));
        $action->setContainer($this->container->get('service_container'));

        $action->execute();

        return $action->getResponse();
    }
}

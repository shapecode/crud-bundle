<?php

namespace Shapecode\Bundle\CRUDBundle\Action;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface ActionInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Action
 * @author  Nikita Loges
 */
interface ActionInterface
{

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack);

    /**
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null);

    /**
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     */
    public function execute();

    /**
     * @return Response
     */
    public function getResponse();

    /**
     * @param OptionsResolver $resolver
     */
    public static function configureOptions(OptionsResolver $resolver);

    /**
     * @return string
     */
    public static function getRoute();
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Factory;

use Shapecode\Bundle\CRUDBundle\Cruding\Manager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ManagerFactory
 *
 * @package Shapecode\Bundle\CRUDBundle\Factory
 * @author  Nikita Loges
 * @company tenolo GbR
 */
class ManagerFactory implements ManagerFactoryInterface
{

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritdoc
     */
    public function create($name)
    {
        $configurations = $this->container->getParameter('shapecode_crud.managers');
        $configuration = (isset($configurations[$name])) ? $configurations[$name] : $configurations['default'];

        $manager = new Manager($name, $configuration);

        return $manager;
    }
}

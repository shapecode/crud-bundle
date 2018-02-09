<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ActionManager
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
class ActionManager implements ActionManagerInterface
{

    /** @var ArrayCollection */
    protected $actions;

    /** @var ContainerInterface */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->actions = new ArrayCollection();
    }

    /**
     * @param $className
     * @param $id
     */
    public function addAction($className, $id)
    {
        $this->actions->set($className, $id);
    }

    /**
     * @param $className
     *
     * @return object
     */
    public function getAction($className)
    {
        if (!$this->hasAction($className)) {
            return new $className;
        }

        $id = $this->actions->get($className);

        return $this->container->get($id);
    }

    /**
     * @param $className
     */
    public function hasAction($className)
    {
        $this->actions->containsKey($className);
    }
}

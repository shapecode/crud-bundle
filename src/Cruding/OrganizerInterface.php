<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Interface OrganizerInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
interface OrganizerInterface
{

    /**
     * @param AbstractCrudInterface $crud
     * @param string                $managerName
     */
    public function addCrud(AbstractCrudInterface $crud, $managerName = 'default');

    /**
     * @return ManagerInterface[]
     */
    public function getManagers();

    /**
     * @param ManagerInterface $manager
     */
    public function addManager(ManagerInterface $manager);

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasManager($name);

    /**
     * @param $name
     *
     * @return ManagerInterface|null
     */
    public function getManager($name);
}

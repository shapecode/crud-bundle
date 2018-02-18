<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Doctrine\Common\Collections\ArrayCollection;
use Shapecode\Bundle\CRUDBundle\Crud\AbstractCrudInterface;

/**
 * Class Organizer
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
class Organizer implements OrganizerInterface
{

    /** @var ManagerInterface[] */
    protected $managers;

    /**
     */
    public function __construct()
    {
        $this->managers = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function addCrud(AbstractCrudInterface $crud, $managerName = 'default')
    {
        if (!$this->hasManager($managerName)) {
            $this->addManager(new Manager($managerName));
        }

        $this->getManager($managerName)->addCrud($crud);
    }

    /**
     * @inheritdoc
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * @inheritdoc
     */
    public function addManager(ManagerInterface $manager)
    {
        return $this->managers->set($manager->getName(), $manager);
    }

    /**
     * @inheritdoc
     */
    public function hasManager($name)
    {
        return $this->managers->containsKey($name);
    }

    /**
     * @inheritdoc
     */
    public function getManager($name)
    {
        return $this->managers->get($name);
    }
}

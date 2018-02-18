<?php

namespace Shapecode\Bundle\CRUDBundle\Controller;

use Shapecode\Bundle\CRUDBundle\Cruding\ExecutionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CrudController
 *
 * @package Shapecode\Bundle\CRUDBundle\Controller
 * @author  Nikita Loges
 */
class CrudController extends Controller
{

    /** @var ExecutionInterface */
    protected $execution;

    /**
     * @param ExecutionInterface $execution
     */
    public function __construct(ExecutionInterface $execution)
    {
        $this->execution = $execution;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function executeAction(Request $request)
    {
        return $this->execution->execute($request);
    }
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Cruding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Interface ExecutionInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Cruding
 * @author  Nikita Loges
 */
interface ExecutionInterface
{

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function execute(Request $request);
}

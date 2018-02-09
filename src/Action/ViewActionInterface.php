<?php

namespace Shapecode\Bundle\CRUDBundle\Action;

/**
 * Interface ViewActionInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Action
 * @author  Nikita Loges
 */
interface ViewActionInterface extends ActionInterface
{

    /**
     * @return string
     */
    public function getTemplateName();

    /**
     * @return array
     */
    public function getTemplateParameters();

    /**
     * @param array $templateParameters
     */
    public function setTemplateParameters(array $templateParameters);

    /**
     * @param $name
     * @param $value
     */
    public function setTemplateParameter($name, $value);

    /**
     * @param array $templateVars
     */
    public function addTemplateParameter(array $templateVars);
}

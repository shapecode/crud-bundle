<?php

namespace Shapecode\Bundle\CRUDBundle\Action;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractViewAction
 *
 * @package Shapecode\Bundle\CRUDBundle\Action
 * @author  Nikita Loges
 */
abstract class AbstractViewAction extends AbstractAction implements ViewActionInterface
{

    /** @var array */
    protected $templateParameters;

    /**
     * @inheritDoc
     */
    public static function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setRequired([
            'template_name'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getTemplateName()
    {
        return $this->getOption('template_name');
    }

    /**
     * @return array
     */
    public function getTemplateParameters()
    {
        return $this->templateParameters;
    }

    /**
     * @param array $templateParameters
     */
    public function setTemplateParameters(array $templateParameters)
    {
        $this->templateParameters = $templateParameters;
    }

    /**
     * @param $name
     * @param $value
     */
    public function setTemplateParameter($name, $value)
    {
        $this->templateParameters[$name] = $value;
    }

    /**
     * @param array $templateVars
     */
    public function addTemplateParameter(array $templateVars)
    {
        foreach ($templateVars as $key => $value) {
            $this->setTemplateParameter($key, $value);
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function render()
    {
        return $this->getContainer()->get('templating')->renderResponse($this->getTemplateName(), $this->getTemplateParameters());
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
    }

    /**
     * @inheritDoc
     */
    public function getResponse()
    {
        return $this->render();
    }
}

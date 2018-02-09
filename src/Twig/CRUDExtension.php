<?php

namespace Shapecode\Bundle\CRUDBundle\Twig;

use Shapecode\Bundle\CRUDBundle\CRUD\Configurator\Configurator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;

/**
 * Class CRUDExtension
 *
 * @package Shapecode\Bundle\CRUDBundle\Twig
 * @author  Nikita Loges
 */
class CRUDExtension extends AbstractExtension
{

    /** @var  TranslatorInterface */
    protected $translator;

    /** @var string */
    protected $crudLayoutTemplate;

    /**
     * @param TranslatorInterface $translator
     * @param string              $crudLayoutTemplate
     */
    public function __construct(TranslatorInterface $translator, $crudLayoutTemplate)
    {
        $this->translator = $translator;
        $this->crudLayoutTemplate = $crudLayoutTemplate;
    }

    /**
     * @inheritDoc
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('crud_wording', [$this, 'getWording']),
            new \Twig_SimpleFunction('crud_can_view', [$this, 'canView']),
            new \Twig_SimpleFunction('crud_has', [$this, 'hasAction']),
            new \Twig_SimpleFunction('crud_permission', [$this, 'hasPermission']),
            new \Twig_SimpleFunction('crud_current_action', [$this, 'currentAction']),
            new \Twig_SimpleFunction('crud_route', [$this, 'getRoute']),
            new \Twig_SimpleFunction('crud_route_name', [$this, 'getRouteName'])
        ];
    }

    /**
     * @param Configurator $configurator
     * @param              $name
     *
     * @return boolean
     */
    public function hasAction(Configurator $configurator, $name)
    {
        return $configurator->hasAction($name);
    }

    /**
     * @param Configurator $configurator
     * @param              $name
     *
     * @return boolean
     */
    public function hasPermission(Configurator $configurator, $name)
    {
        return $configurator->hasPermission($name);
    }

    /**
     * @param Configurator $configurator
     * @param              $name
     *
     * @return boolean
     */
    public function canView(Configurator $configurator, $name)
    {
        return ($configurator->hasAction($name) && $configurator->hasPermission($name));
    }

    /**
     * @param Configurator $configurator
     *
     * @return boolean
     */
    public function currentAction(Configurator $configurator)
    {
        return $configurator->getCurrentAction();
    }

    /**
     * @param Configurator $configurator
     * @param              $name
     * @param array        $parameters
     * @param int          $referenceType
     *
     * @return string
     */
    public function getRoute(Configurator $configurator, $name, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $configurator->getRouteUrl($name, $parameters, $referenceType);
    }

    /**
     * @param Configurator $configurator
     * @param              $name
     *
     * @return string
     */
    public function getRouteName(Configurator $configurator, $name)
    {
        return $configurator->getRouteName($name);
    }

    /**
     * @param Configurator $configurator
     * @param              $name
     * @param array        $options
     *
     * @return string
     */
    public function getWording(Configurator $configurator, $name, array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'parameters' => [],
            'locale'     => null,
            'domain'     => null,
        ]);

        $resolver->setAllowedTypes('parameters', ['array']);
        $resolver->setAllowedTypes('locale', ['string', 'null']);
        $resolver->setAllowedTypes('domain', ['string', 'null']);

        $options = $resolver->resolve($options);

        return $this->translator->trans($configurator->getWording()->get($name), $options['parameters'], $options['domain'], $options['locale']);
    }

}
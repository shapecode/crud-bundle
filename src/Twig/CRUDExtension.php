<?php

namespace Shapecode\Bundle\CRUDBundle\Twig;

use Shapecode\Bundle\CRUDBundle\Cruding\CrudHelperInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
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

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
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
            new \Twig_SimpleFunction('crud_route_name', [$this, 'getRouteName']),
            new \Twig_SimpleFunction('crud_manager_option', [$this, 'getManagerOption']),
        ];
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     *
     * @return boolean
     */
    public function hasAction(CrudHelperInterface $helper, $name)
    {
        return $helper->hasAction($name);
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     *
     * @return boolean
     */
    public function hasPermission(CrudHelperInterface $helper, $name)
    {
        return $helper->hasPermission($name);
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     *
     * @return boolean
     */
    public function canView(CrudHelperInterface $helper, $name)
    {
        return ($helper->hasAction($name) && $helper->hasPermission($name));
    }

    /**
     * @param CrudHelperInterface $helper
     *
     * @return boolean
     */
    public function currentAction(CrudHelperInterface $helper)
    {
        return $helper->getCurrentAction();
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     * @param array               $parameters
     *
     * @return string
     */
    public function getRoute(CrudHelperInterface $helper, $name, $parameters = [])
    {
        return $helper->generateUrl($name, $parameters);
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     *
     * @return string
     */
    public function getRouteName(CrudHelperInterface $helper, $name)
    {
        return $helper->getRouteName($name);
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     *
     * @return string
     */
    public function getManagerOption(CrudHelperInterface $helper, $name)
    {
        return $helper->getManagerOption($name);
    }

    /**
     * @param CrudHelperInterface $helper
     * @param                     $name
     * @param array               $options
     *
     * @return string
     */
    public function getWording(CrudHelperInterface $helper, $name, array $options = [])
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

        return $this->translator->trans($helper->getWording()->get($name), $options['parameters'], $options['domain'], $options['locale']);
    }

}
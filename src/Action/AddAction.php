<?php

namespace Shapecode\Bundle\CRUDBundle\Action;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddAction
 *
 * @package Shapecode\Bundle\CRUDBundle\Action
 * @author  Nikita Loges
 */
class AddAction extends AbstractViewAction implements ActionInterface
{

    /** @var object */
    protected $entity;

    /**
     * @inheritDoc
     */
    public static function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'template_name' => '@ShapecodeCRUD/Crud/add.html.twig',
            'form_type'     => null,
            'form_options'  => [],
        ]);

        $resolver->setAllowedTypes('form_type', ['string']);
        $resolver->setAllowedTypes('form_options', ['array']);
    }

    /**
     * @return string
     */
    protected function getFormType()
    {
        return $this->getOption('form_type');
    }

    /**
     * @return array
     */
    protected function getFormOptions()
    {
        return $this->getOption('form_options');
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getForm()
    {
        return $this->container->get('form.factory')->create($this->getFormType(), $this->getEntity(), $this->getFormOptions());
    }

    /**
     * @return object
     */
    protected function getEntity()
    {
        if (is_null($this->entity)) {
            $className = $this->getRepository()->getClassName();
            $this->entity = new $className();
        }

        return $this->entity;
    }

    /**
     *
     */
    protected function handleValidForm()
    {
        $em = $this->getDoctrine()->getManager();

        $em->persist($this->getEntity());
        $em->flush();
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $request = $this->getRequest();
        $form = $this->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->handleValidForm();
            }
        }

        $this->addTemplateParameter([
            'form'   => $form->createView(),
            'entity' => $this->getEntity(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function getRoute()
    {
        return '/add';
    }
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Action;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddAction
 *
 * @package Shapecode\Bundle\CRUDBundle\Action
 * @author  Nikita Loges
 */
class EditAction extends AddAction implements ActionInterface
{

    /**
     * @inheritDoc
     */
    public static function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'template_name' => '@ShapecodeCRUD/Crud/edit.html.twig',
            'find_by'       => function (EntityRepository $repository, Request $request) {
                return $repository->find($request->get('id'));
            },
        ]);
    }

    /**
     * @return object
     */
    protected function getEntity()
    {
        if (is_null($this->entity)) {
            $this->entity = $this->find();
        }

        return $this->entity;
    }

    /**
     * @return mixed
     */
    protected function find()
    {
        $repo = $this->getRepository();
        $request = $this->getRequest();

        $function = $this->getOption('find_by');

        return $function($repo, $request);
    }

    /**
     *
     */
    protected function handleValidForm()
    {

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
            'form' => $form->createView(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function getRoute()
    {
        return '/{id}/edit';
    }

    /**
     * @inheritDoc
     */
    public static function getRouteFormattedParams(array $params, array $options = [])
    {
        $object = $params['object'];

        $params['id'] = $object->getId();

        unset($params['object']);

        return $params;
    }
}

<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Shapecode\Bundle\CRUDBundle\Action\AddAction;
use Shapecode\Bundle\CRUDBundle\Action\EditAction;
use Shapecode\Bundle\CRUDBundle\Action\ListAction;
use Shapecode\Bundle\CRUDBundle\Cruding\CrudBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractCrud
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
abstract class AbstractCrud extends BaseCrud
{

    /**
     * @inheritdoc
     */
    public function buildCrud(CrudBuilderInterface $builder, array $options)
    {
        $builder->add('list', ListAction::class, [
            'entity_name' => $options['entity_name']
        ]);

        if ($options['add_enable']) {
            $builder->add('add', AddAction::class, [
                'entity_name' => $options['entity_name'],
                'form_type'   => $options['form_type']
            ]);
        }

        if ($options['edit_enable']) {
            $builder->add('edit', EditAction::class, [
                'entity_name' => $options['entity_name'],
                'form_type'   => $options['form_type']
            ]);
        }
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'add_enable'  => true,
            'edit_enable' => true,
            'form_type'   => null
        ]);
    }
}

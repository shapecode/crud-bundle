<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Shapecode\Bundle\CRUDBundle\Action\ListAction;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractCrud
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
abstract class AbstractCrud implements AbstractCrudInterface
{

    /**
     * @inheritdoc
     */
    public function buildCrud(CrudBuilderInterface $builder, array $options)
    {
        $builder->add('list', ListAction::class, [
            'entity_class' => $options['entity_class']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'entity_class'
        ]);

        $resolver->setAllowedTypes('entity_class', ['string']);
    }
}

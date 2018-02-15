<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AbstractCrud
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
abstract class BaseCrud implements AbstractCrudInterface
{

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'entity_name'
        ]);

        $resolver->setAllowedTypes('entity_name', ['string']);
    }
}

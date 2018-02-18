<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Shapecode\Bundle\CRUDBundle\Cruding\CrudBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Interface AbstractAdminInterface
 *
 * @package Shapecode\Bundle\CRUDBundle\Crud
 * @author  Nikita Loges
 */
interface AbstractCrudInterface
{

    /**
     * @param CrudBuilderInterface $builder
     * @param array                $options
     */
    public function buildCrud(CrudBuilderInterface $builder, array $options);

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver);

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getRoute();
}

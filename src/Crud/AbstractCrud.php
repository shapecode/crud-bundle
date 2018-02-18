<?php

namespace Shapecode\Bundle\CRUDBundle\Crud;

use Shapecode\Bundle\CRUDBundle\Action\ListAction;

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
    }
}

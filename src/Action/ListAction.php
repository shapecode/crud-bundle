<?php

namespace Shapecode\Bundle\CRUDBundle\Action;

use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ListAction
 *
 * @package Shapecode\Bundle\CRUDBundle\Action
 * @author  Nikita Loges
 */
class ListAction extends AbstractViewAction implements ActionInterface
{

    /** @var PaginationInterface */
    protected $pagination;

    /** @var mixed */
    protected $paginationTarget;

    /** @var FormInterface */
    protected $filterForm;

    /**
     * @inheritDoc
     */
    public static function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'template_name'              => '@ShapecodeCRUD/Crud/list.html.twig',
            'sort_field_query_name'      => 'sort',
            'sort_field_name'            => 'p.id',
            'sort_direction_query_name'  => 'direction',
            'sort_direction'             => 'asc',
            'page_query_name'            => 'page',
            'page_range'                 => 10,
            'list_item_limit'            => 20,
            'list_item_limit_max'        => 500,
            'list_item_limit_query_name' => 'limit',
            'pagination_options'         => [],
        ]);

        $resolver->setAllowedTypes('sort_field_query_name', ['string']);
        $resolver->setAllowedTypes('sort_field_name', ['string']);
        $resolver->setAllowedTypes('sort_direction_query_name', ['string']);
        $resolver->setAllowedTypes('sort_direction', ['string']);
        $resolver->setAllowedTypes('page_query_name', ['string']);
        $resolver->setAllowedTypes('page_range', ['int']);
        $resolver->setAllowedTypes('list_item_limit', ['int']);
        $resolver->setAllowedTypes('list_item_limit_max', ['int']);
        $resolver->setAllowedTypes('list_item_limit_query_name', ['string']);
        $resolver->setAllowedTypes('pagination_options', ['array']);

        $resolver->setNormalizer('pagination_options', function (Options $options, $value) {
            $default = [
                'first_label' => 'Erste',
                'last_label'  => 'Letzte',
                'pageRange'   => $options['page_range']
            ];

            return array_replace_recursive($default, $value);
        });
    }

    /**
     * @return null|string
     */
    protected function getSortFieldName()
    {
        $paramName = $this->getOption('sort_field_query_name');
        $default = $this->getOption('sort_field_name');

        $value = $this->getRequest()->get($paramName, $default);

        if (is_null($value)) {
            $value = $default;
        }

        return $value;
    }

    /**
     * @return null|string
     */
    protected function getSortDirection()
    {
        $paramName = $this->getOption('sort_direction_query_name');
        $default = $this->getOption('sort_direction');

        $value = $this->getRequest()->get($paramName, $default);

        if (is_null($value) || $value == '-') {
            $value = $default;
        }

        return $value;
    }

    /**
     * @return int
     */
    protected function getListItemLimit()
    {
        $paramName = $this->getOption('list_item_limit_query_name');
        $default = $this->getOption('list_item_limit');

        $limit = $this->getRequestParameter($paramName, $default);

        if ($limit > $this->getOption('list_item_limit_max')) {
            $limit = $this->getOption('list_item_limit_max');
        }

        return $limit;
    }

    /**
     * @return int
     */
    protected function getPage()
    {
        $paramName = $this->getOption('page_query_name');

        return $this->getRequestParameter($paramName, 1);
    }

    /**
     * @return int
     * @deprecated
     */
    protected function getPageRange()
    {
        return $this->getOption('page_range');
    }

    /**
     * @return \Knp\Component\Pager\Paginator
     */
    protected function getPaginator()
    {
        return $this->getContainer()->get('knp_paginator');
    }

    /**
     * @return array
     */
    protected function getPaginationOptions()
    {
        $options = $this->getOptions();
        $paginationOptions = $options['pagination_options'];

        return array_replace_recursive($paginationOptions, [
            'defaultSortFieldName' => $this->getSortFieldName(),
            'defaultSortDirection' => $this->getSortDirection(),
        ]);
    }

    /**
     * @return mixed
     */
    protected function getPaginationTarget()
    {
        if (empty($this->paginationTarget)) {
            $target = $this->initPaginationTarget();

            if (!empty($target)) {
                $this->paginationTarget = $target;
            }
        }

        return $this->paginationTarget;
    }

    /**
     *
     */
    protected function initPaginationTarget()
    {
        return $this->getQueryBuilder();
    }

    /**
     * @return PaginationInterface
     */
    protected function getPagination()
    {
        if (empty($this->pagination)) {
            $this->initPagination();
        }

        return $this->pagination;
    }

    /**
     *
     */
    protected function initPagination()
    {
        $target = $this->getPaginationTarget();
        $page = $this->getPage();
        $limit = $this->getListItemLimit();
        $options = $this->getPaginationOptions();

        $this->pagination = $this->getPaginator()->paginate($target, $page, $limit, $options);
    }

    /**
     * @return mixed
     */
    protected function getQueryBuilder()
    {
        $qb = $this->getRepository()->getQueryBuilder();

        $this->buildQuery($qb);

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     */
    protected function buildQuery(QueryBuilder $qb)
    {
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->addTemplateParameter([
            'pagination' => $this->getPagination(),
            'objects'    => $this->getPagination(),
            'counter'    => ($this->getListItemLimit() * ($this->getPage() - 1) + 1)
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function getRoute()
    {
        return '/';
    }
}

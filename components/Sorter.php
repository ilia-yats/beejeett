<?php

namespace components;

use Application;

class Sorter
{
    const SORT_FIELD_PARAM = 's';
    const SORT_ORDER_PARAM = 'o';

    private $router;


    private $fieldsLabels;

    private $sortField;

    private $sortOrder;

    public function __construct(array $request, array $fieldsLabels, Router $router)
    {
        $this->router = $router;
        $this->sortField = $request[self::SORT_FIELD_PARAM] ?? '';
        $this->sortOrder = $request[self::SORT_ORDER_PARAM] ?? '';
        $this->fieldsLabels = $fieldsLabels;
    }

    public function getSortField()
    {
        return $this->sortField;
    }

    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    public function getLinks()
    {
        $result = [];
        foreach ($this->fieldsLabels as $field => $label) {
            $order = 'asc';
            if ($this->getSortField() === $field) {
                if ($this->getSortOrder() === 'asc') {
                    $order = 'desc';
                }
            }

            $url = $this->router->complementUrl([self::SORT_ORDER_PARAM => $order, self::SORT_FIELD_PARAM => $field]);
            $result[$url] = $label.' '.$order;
        }

        return $result;
    }
}
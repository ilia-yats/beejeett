<?php

namespace components;


class Paginator
{
    const PAGE_PARAM = 'p';

    const PAGE_ITEMS = 1;

    public $hasNextPage;

    public $hasPrevPage;

    private $currentPage;

    private $router;

    private $totalCount;

    public function __construct(string $totalCount, array $request, Router $router)
    {
        $this->router = $router;
        $this->totalCount = $totalCount;
        $this->currentPage = isset($request[self::PAGE_PARAM]) ? intval($request[self::PAGE_PARAM]) : 1;

        $this->hasNextPage = (self::PAGE_ITEMS * $this->currentPage) < $this->totalCount;
        $this->hasPrevPage = $this->currentPage > 1;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getNextPageLink()
    {
        return $this->router->complementUrl([self::PAGE_PARAM => $this->getCurrentPage() + 1]);
    }

    public function getPrevPageLink()
    {
        return $this->router->complementUrl([self::PAGE_PARAM => $this->getCurrentPage() - 1]);
    }}
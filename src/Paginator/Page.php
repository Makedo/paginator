<?php

namespace Makedo\Paginator;

class Page
{
    /** @var int */
    public $currentPage;

    /**
     * @var int
     */
    public $perPage;

    /**
     * @var iterable
     */
    public $items;

    /**
     * @var bool
     */
    public $hasPrev;

    /**
     * @var bool
     */
    public $hasNext;
}
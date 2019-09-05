<?php

namespace Makedo\Paginator\Page;

use Makedo\Paginator\Loader\Result;

class Page implements \IteratorAggregate
{
    /**
     * @var int
     */
    public $currentPage;

    /**
     * @var int
     */
    public $perPage;

    /**
     * @var Result
     */
    public $items;

    /**
     * @var int
     */
    public $itemsCount;

    /**
     * @var bool
     */
    public $hasPrev;

    /**
     * @var bool
     */
    public $hasNext;

    /**
     * @var ?int
     */
    public $total;

    /**
     * @var ?int
     */
    public $totalPages;


    public function getIterator()
    {
        return $this->items;
    }
}
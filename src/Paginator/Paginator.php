<?php

namespace Makedo\Paginator;

use Makedo\Paginator\Loader\Loader;

class Paginator
{
    public function paginate(
        int $currentPage,
        int $perPage,
        Loader $loader
    ): Page
    {
        $page = new Page();

        $page->currentPage = $currentPage;
        $page->perPage = $perPage;

        $offset = ($currentPage - 1) * $perPage;
        $items = $loader->load($perPage + 1, $offset);

        $page->hasPrev = $currentPage > 1;
        $page->hasNext = count($items) > $perPage;

        $page->items = new \LimitIterator($items->getIterator(), 0, $perPage);

        return $page;
    }
}

<?php

namespace Makedo\Paginator\Strategy\Next;

class Factory
{
    public function createItemsCountStrategy(int $itemsCount, int $perPage): ItemsCount
    {
        return new ItemsCount($itemsCount, $perPage);
    }

    public function createPagesCountStrategy(int $pagesCount, int $currentPage)
    {
        return new PagesCount($pagesCount, $currentPage);
    }
}

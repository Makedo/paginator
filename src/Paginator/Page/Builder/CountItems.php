<?php


namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Page;

class CountItems implements Pipe
{
    public function build(Page $page): Page
    {
        $count = $page->items->count();
        $page->itemsCount = $count > $page->perPage ? $count - 1 : $count;

        return $page;
    }
}

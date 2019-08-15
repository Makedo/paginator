<?php


namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Page;

class HasNextByPages implements Pipe
{
    public function build(Page $page): Page
    {
        $page->hasNext = $page->currentPage < $page->totalPages;
        return $page;
    }
}

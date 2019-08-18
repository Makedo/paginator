<?php

namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Page;

class HasNextByItemsCount implements Pipe
{
    public function build(Page $page): Page
    {
        $page->hasNext = $page->items->count() > $page->perPage;
        return $page;
    }

}

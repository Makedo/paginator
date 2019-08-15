<?php


namespace Makedo\Paginator\Page\Builder;


use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Page\Page;

class CountTotal implements Pipe
{
    /**
     * @var Counter
     */
    private $counter;

    public function __construct(Counter $counter)
    {
        $this->counter = $counter;
    }

    public function build(Page $page): Page
    {
        $page->total = $this->counter->count();
        $page->totalPages = (int) ceil($page->total / $page->perPage);

        return $page;
    }
}

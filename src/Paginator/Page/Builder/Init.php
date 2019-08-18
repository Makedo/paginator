<?php

namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Page;

class Init implements Pipe
{
    /**
     * @var int
     */
    private $perPage;

    /**
     * @var int
     */
    private $currentPage;

    public function __construct(int $perPage, ?int $currentPage)
    {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    public function build(Page $page): Page
    {
        $page->perPage = $this->perPage;
        $page->currentPage = $this->currentPage;

        return $page;
    }
}

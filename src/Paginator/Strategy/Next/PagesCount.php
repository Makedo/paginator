<?php

namespace Makedo\Paginator\Strategy\Next;

class PagesCount implements Next
{
    /**
     * @var int
     */
    private $pagesCount;
    /**
     * @var int
     */
    private $currentPage;

    public function __construct(int $pagesCount, int $currentPage)
    {
        $this->pagesCount = $pagesCount;
        $this->currentPage = $currentPage;
    }

    public function hasNext(): bool
    {
        return $this->pagesCount > $this->currentPage;
    }

}

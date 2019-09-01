<?php

namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Page;
use Makedo\Paginator\Strategy\Skip\Skip;

class HasPrev implements Pipe
{
    /**
     * @var Skip
     */
    private $skipStrategy;

    public function __construct(Skip $skipStrategy)
    {
        $this->skipStrategy = $skipStrategy;
    }

    public function build(Page $page): Page
    {
        $page->hasPrev = $this->skipStrategy->hasSkip();
        return $page;
    }

}

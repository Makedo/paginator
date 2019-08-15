<?php

namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\Page\Page;
use Makedo\Paginator\Strategy\Limit\Limit;
use Makedo\Paginator\Strategy\Skip\Skip;

class LoadItems implements Pipe
{
    /**
     * @var Loader
     */
    private $loader;

    /**
     * @var Limit
     */
    private $limitStrategy;

    /**
     * @var Skip
     */
    private $skipStrategy;

    public function __construct(Loader $loader, Limit $limitStrategy, Skip $skipStrategy)
    {
        $this->loader = $loader;
        $this->limitStrategy = $limitStrategy;
        $this->skipStrategy = $skipStrategy;
    }

    public function build(Page $page): Page
    {
        $limit = $this->limitStrategy->countLimit();
        $skip  = $this->skipStrategy->countSkip();

        $items = $this->loader->load($limit, $skip);

        $page->hasPrev = $this->skipStrategy->hasSkip();

        $page->items = $items instanceof Result
            ? $items
            : Result::fromIterable($items, $page->perPage)
        ;

        return $page;
    }
}

<?php

namespace Makedo\Paginator\Factory;

use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Page\Builder\CountItems;
use Makedo\Paginator\Page\Builder\HasNextByItemsCount;
use Makedo\Paginator\Page\Builder\HasPrev;
use Makedo\Paginator\Page\Builder\Init;
use Makedo\Paginator\Page\Builder\LoadItems;
use Makedo\Paginator\Paginator;
use Makedo\Paginator\Strategy\Limit\PerPagePlusOne;
use Makedo\Paginator\Strategy\Skip\ByOffset;

class SkipByOffset extends AbstractFactory
{
    public function createPaginator(Loader $loader, int $currentPage): Paginator
    {
        $currentPage = $this->filterLessOrEqualZero($currentPage, 1);

        $skipStrategy  = new ByOffset($this->perPage, $currentPage);
        $limitStrategy = new PerPagePlusOne($this->perPage);

        $paginator = new Paginator();
        $paginator
            ->addPipe(new Init($this->perPage, $currentPage))
            ->addPipe(new HasPrev($skipStrategy))
            ->addPipe(new LoadItems($loader, $limitStrategy, $skipStrategy))
            ->addPipe(new CountItems())
            ->addPipe(new HasNextByItemsCount())
        ;

        return $paginator;
    }
}

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
use Makedo\Paginator\Strategy\Skip\ById;

class SkipById extends AbstractFactory
{
    public function createPaginator(Loader $loader, int $id, ?int $currentPage = null): Paginator
    {
        $skipStrategy  = new ById($id);
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

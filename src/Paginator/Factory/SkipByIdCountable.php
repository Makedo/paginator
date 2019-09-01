<?php


namespace Makedo\Paginator\Factory;


use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Page\Builder\CountItems;
use Makedo\Paginator\Page\Builder\CountTotal;
use Makedo\Paginator\Page\Builder\HasNextByItemsCount;
use Makedo\Paginator\Page\Builder\HasPrev;
use Makedo\Paginator\Page\Builder\Init;
use Makedo\Paginator\Page\Builder\LoadItems;
use Makedo\Paginator\Paginator;
use Makedo\Paginator\Strategy\Limit\PerPagePlusOne;
use Makedo\Paginator\Strategy\Skip\ById;

class SkipByIdCountable extends AbstractFactory
{
    public function createPaginator(
        Loader $loader,
        Counter $counter,
        int $id
    ): Paginator
    {
        $limitStrategy = new PerPagePlusOne($this->perPage);
        $hasNext = new HasNextByItemsCount();
        $skipStrategy  = new ById($id);

        $paginator = new Paginator();
        $paginator
            ->addPipe(new Init($this->perPage))
            ->addPipe(new HasPrev($skipStrategy))
            ->addPipe(new LoadItems($loader, $limitStrategy, $skipStrategy))
            ->addPipe(new CountItems())
            ->addPipe(new CountTotal($counter))
            ->addPipe($hasNext)
        ;

        return $paginator;
    }

}
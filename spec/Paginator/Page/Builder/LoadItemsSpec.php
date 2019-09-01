<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Builder\LoadItems;
use Makedo\Paginator\Page\Page;
use Makedo\Paginator\Strategy\Limit\Limit;
use Makedo\Paginator\Strategy\Skip\Skip;
use PhpSpec\ObjectBehavior;

class LoadItemsSpec extends ObjectBehavior
{
    function let(Loader $loader, Limit $limitStrategy, Skip $skipStrategy)
    {
        $this->beConstructedWith($loader, $limitStrategy, $skipStrategy);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LoadItems::class);
        $this->shouldImplement(Pipe::class);
    }

    public function it_fills_page_with_items(
        Page $page,
        Loader $loader,
        Limit $limitStrategy,
        Skip $skipStrategy
    ) {
        $limit = 22;
        $limitStrategy->countLimit()
            ->willReturn($limit)
            ->shouldBeCalled()
        ;

        $skip = 5;
        $skipStrategy->countSkip()
            ->willReturn($skip)
            ->shouldBeCalled()
        ;

        $items = [1,2,3,4,5];
        $loader->load($limit, $skip)
            ->willReturn($items)
            ->shouldBeCalled()
        ;

        $page = $this->build($page);

        $page->items->shouldBeLike(Result::fromIterable($items));
    }
}

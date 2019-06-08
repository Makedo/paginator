<?php

namespace spec\Makedo\Paginator;

use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\Paginator;
use Makedo\Paginator\Page;
use PhpSpec\ObjectBehavior;

class PaginatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Paginator::class);
    }

    function it_can_paginate(Loader $loader)
    {
        $currentPage = 5;
        $perPage = 2;

        $items = [['item1'], ['item2'], ['item3']];
        $pageItems = [['item1'], ['item2']];

        $result = Result::fromIterable($items);

        $offset = ($currentPage - 1) * $perPage; //@todo - duplicate logic in spec Add OffsetStrategy

        //@todo duplicate logic
        $loader->load($perPage + 1, $offset)->willReturn($result);

        $page = $this->paginate(
            $currentPage,
            $perPage,
            $loader
        );

        $page->shouldBeAnInstanceOf(Page::class);

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe($perPage);
        $page->items->shouldIterateAs($pageItems);

        $hasPrev = $currentPage > 1; //@todo - duplicate logic in spec. Add PrevStrategy
        $page->hasPrev->shouldBe($hasPrev);

        $hasNext = count($items) > count($pageItems); //@todo = duplicate logic in spec. Add NextStrategy
        $page->hasNext = $hasNext;
    }
}

<?php

namespace spec\Makedo\Paginator\Factory;

use Makedo\Paginator\Factory\SkipById;
use Makedo\Paginator\Factory\SkipByOffset;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;

class SkipByOffsetSpec extends ObjectBehavior
{
    const PER_PAGE = 4;

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SkipByOffset::class);
    }

    function it_creates_paginator_with_skip_by_offset(Loader $loader)
    {
        $currentPage = 5;
        $offset = 16;
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $offset)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $paginator = $this->createPaginator($loader, $currentPage);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }
}

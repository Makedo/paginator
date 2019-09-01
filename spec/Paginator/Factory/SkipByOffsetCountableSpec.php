<?php

namespace spec\Makedo\Paginator\Factory;

use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Factory\SkipByOffsetCountable;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;

class SkipByOffsetCountableSpec extends ObjectBehavior
{
    const PER_PAGE = 4;

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SkipByOffsetCountable::class);
    }

    function it_creates_paginator_with_skip_by_offset_and_count(Loader $loader, Counter $counter)
    {
        $currentPage = 3;
        $skip = self::PER_PAGE * ($currentPage - 1);
        $limit = self::PER_PAGE;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $skip)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $total = 21;
        $counter->count()
            ->willReturn($total)
            ->shouldBeCalled()
        ;

        $paginator = $this->createPaginator(
            $loader,$counter, $currentPage
        );

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->count()->shouldBe($result->count());
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);

        $page->total->shouldBe($total);
        $page->totalPages->shouldBe(6);

    }
}

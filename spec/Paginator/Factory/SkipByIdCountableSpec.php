<?php

namespace spec\Makedo\Paginator\Factory;

use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Factory\SkipByIdCountable;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;

class SkipByIdCountableSpec extends ObjectBehavior
{
    const PER_PAGE = 4;

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SkipByIdCountable::class);
    }

    function it_creates_paginator_with_skip_by_id_and_counter(Loader $loader, Counter $counter)
    {
        $id = 5;
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $id)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $total = 21;
        $counter->count()
            ->willReturn($total)
            ->shouldBeCalled()
        ;

        $paginator = $this->createPaginator($loader, $counter, $id);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe(null);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
        $page->totalPages->shouldBe(6);
        $page->total->shouldBe($total);
    }
}

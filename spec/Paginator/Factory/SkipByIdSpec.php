<?php

namespace spec\Makedo\Paginator\Factory;

use Makedo\Paginator\Factory\SkipById;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;

class SkipByIdSpec extends ObjectBehavior
{
    const PER_PAGE = 4;

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SkipById::class);
    }

    function it_creates_paginator_with_skip_by_id(Loader $loader)
    {
        $id = 5;
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $id)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $paginator = $this->createPaginator($loader, $id);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe(null);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }

    function it_creates_paginator_with_skip_by_id_and_current_page(Loader $loader)
    {
        $id = 5;
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $id)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $currentPage = 10;
        $paginator = $this->createPaginator($loader, $id, $currentPage);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }

}
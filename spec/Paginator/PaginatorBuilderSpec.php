<?php


namespace spec\Makedo\Paginator;


use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\PaginatorBuilder;
use PhpSpec\ObjectBehavior;

class PaginatorBuilderSpec extends ObjectBehavior
{
    const PER_PAGE = 4;
    const CURRENT_PAGE = 2;

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PaginatorBuilder::class);
    }

    function it_builds_paginator_with_offset_skip_strategy(Loader $loader)
    {
        $currentPage = self::CURRENT_PAGE;
        $skip = self::PER_PAGE * ($currentPage - 1);
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $skip)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $paginator = $this->build($currentPage, $loader);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }

    function it_builds_paginator_with_by_id_skip_strategy(Loader $loader)
    {
        $currentPage = self::CURRENT_PAGE;
        $id = 5;
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $id)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $paginator = $this
            ->skipById($id)
            ->build($currentPage, $loader)
        ;

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }

    function it_builds_paginator_with_count(Loader $loader, Counter $counter)
    {
        $currentPage = self::CURRENT_PAGE;
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

        $paginator = $this->build($currentPage, $loader, $counter);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);

        $page->total->shouldBe($total);
        $page->totalPages->shouldBe(6);
    }
}

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

        $paginator = $this
            ->currentPage($currentPage)
            ->build($loader);

        $page = $paginator->paginate();

        $page->currentPage->shouldBe($currentPage);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->count()->shouldBe($result->count());
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }

    function it_builds_paginator_with_by_id_skip_strategy(Loader $loader)
    {
        $id = 5;
        $limit = self::PER_PAGE + 1;

        $result = Result::fromArray([1,2,3,4,5], self::PER_PAGE);
        $loader->load($limit, $id)
            ->willReturn($result)
            ->shouldBeCalled()
        ;

        $paginator = $this
            ->skipById($id)
            ->build($loader)
        ;

        $page = $paginator->paginate();

        $page->currentPage->shouldBe(null);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);
    }

    function it_builds_paginator_with_offset_skip_strategy_and_count(
        Loader $loader,
        Counter $counter
    ) {
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

        $paginator = $this
            ->currentPage($currentPage)
            ->build($loader, $counter)
        ;

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

    function it_builds_paginator_with_skip_by_id_and_count(
        Loader $loader,
        Counter $counter
    ) {
        $id = 55;
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

        $paginator = $this
            ->skipById($id)
            ->build($loader, $counter)
        ;

        $page = $paginator->paginate();

        $page->currentPage->shouldBe(null);
        $page->perPage->shouldBe(self::PER_PAGE);
        $page->itemsCount->shouldBe(self::PER_PAGE);
        $page->items->count()->shouldBe($result->count());
        $page->items->shouldBe($result);
        $page->hasPrev->shouldBe(true);
        $page->hasNext->shouldBe(true);

        $page->total->shouldBe($total);
        $page->totalPages->shouldBe(6);
    }

    function it_builds_paginator_with_skip_by_id_and_count_and_current_page(
        Loader $loader,
        Counter $counter
    ) {
        $currentPage = 3;
        $id = 55;
        $limit = self::PER_PAGE;

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

        $paginator = $this
            ->skipById($id)
            ->currentPage($currentPage)
            ->build($loader, $counter)
        ;

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

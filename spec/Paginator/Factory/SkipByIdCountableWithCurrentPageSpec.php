<?php


namespace spec\Makedo\Paginator\Factory;

use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Factory\SkipByIdCountableWithCurrentPage;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;

class SkipByIdCountableWithCurrentPageSpec extends ObjectBehavior
{
    const PER_PAGE = 4;

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(
            SkipByIdCountableWithCurrentPage::class
        );
    }

    function it_creates_paginator_with_skip_by_id_count_and_curent_page(
        Loader $loader, Counter $counter
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

        $paginator = $this->createPaginator(
            $loader, $counter, $id, $currentPage
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
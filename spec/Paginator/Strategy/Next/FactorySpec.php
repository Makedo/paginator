<?php

namespace spec\Makedo\Paginator\Strategy\Next;

use Makedo\Paginator\Strategy\Next\Factory;
use Makedo\Paginator\Strategy\Next\ItemsCount;
use Makedo\Paginator\Strategy\Next\PagesCount;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Factory::class);
    }

    function it_creates_items_count_next_strategy()
    {
        $itemsCount = 2;
        $perPage = 10;

        $nextStrategy = $this->createItemsCountStrategy($itemsCount, $perPage);
        $nextStrategy->shouldBeLike(new ItemsCount($itemsCount, $perPage));
    }

    function it_creates_pages_count_next_strategy()
    {
        $pagesCount = 2;
        $currentPage = 10;

        $nextStrategy = $this->createPagesCountStrategy($pagesCount, $currentPage);
        $nextStrategy->shouldBeLike(new PagesCount($pagesCount, $currentPage));
    }
}

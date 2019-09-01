<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\Page\Builder\CountItems;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;

class CountItemsSpec extends ObjectBehavior
{
    const PER_PAGE = 3;

    function it_is_initializable()
    {
        $this->shouldHaveType(CountItems::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_sets_items_count(Page $page)
    {
        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();
        $page->items = Result::fromIterable([1,2,3]);
        $page->perPage = 10;

        $page = $this->build($page);

        $page->itemsCount->shouldBe(self::PER_PAGE);
    }

    function it_sets_items_count_as_per_page(Page $page)
    {
        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();

        $page->items = Result::fromIterable([1,2,3,4]);
        $page->perPage = self::PER_PAGE;

        $page = $this->build($page);

        $page->itemsCount->shouldBe(self::PER_PAGE);
    }
}

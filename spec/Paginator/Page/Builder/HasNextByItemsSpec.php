<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Loader\Result;
use Makedo\Paginator\Page\Builder\HasNextByItems;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use PhpSpec\ObjectBehavior;

class HasNextByItemsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HasNextByItems::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_fills_page_with_has_next_value_true(Page $page)
    {
        $page = $page->getWrappedObject();
        $page->items = Result::fromArray([1,2,3]);
        $page->perPage = 2;

        $page = $this->build($page);

        $page->hasNext->shouldBe(true);
    }

    function it_fills_page_with_has_next_value_false(Page $page)
    {
        $page = $page->getWrappedObject();
        $page->items = Result::fromArray([1,2,3]);
        $page->perPage = 4;

        $page = $this->build($page);

        $page->hasNext->shouldBe(false);
    }
}

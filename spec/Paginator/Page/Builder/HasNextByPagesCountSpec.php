<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Builder\HasNextByPagesCount;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;

class HasNextByPagesCountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(HasNextByPagesCount::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_fills_page_with_has_next_value_true(Page $page)
    {
        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();
        $page->totalPages = 10;
        $page->currentPage = 2;

        $page = $this->build($page);

        $page->hasNext->shouldBe(true);
    }

    function it_fills_page_with_has_next_value_false(Page $page)
    {
        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();
        $page->totalPages = 10;
        $page->currentPage = 10;

        $page = $this->build($page);

        $page->hasNext->shouldBe(false);
    }
}

<?php

namespace spec\Makedo\Paginator\Strategy\Next;

use Makedo\Paginator\Strategy\Next\Next;
use Makedo\Paginator\Strategy\Next\PagesCount;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PagesCountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(1, 1);
        $this->shouldHaveType(PagesCount::class);
        $this->shouldImplement(Next::class);
    }

    function it_has_next_when_pages_count_more_than_current_page()
    {
        $pagesCount  = 200;
        $currentPage = 1;

        $this->beConstructedWith($pagesCount, $currentPage);

        $this->hasNext()->shouldBe(true);
    }

    function it_has_no_next_when_pages_count_equals_current_page()
    {
        $pagesCount  = 200;
        $currentPage = 200;

        $this->beConstructedWith($pagesCount, $currentPage);

        $this->hasNext()->shouldBe(false);
    }
}

<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Page\Builder\CountTotal;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;

class CountTotalSpec extends ObjectBehavior
{
    function let(Counter $counter)
    {
        $this->beConstructedWith($counter);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountTotal::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_fills_page_with_total_and_total_pages_count(Counter $counter, Page $page)
    {
        $total = 10;
        $counter->count()->willReturn($total);

        /** @var Page|Subject $page */
        $page = $page->getWrappedObject();
        $page->perPage = 6;

        $page = $this->build($page);

        $page->total->shouldBe($total);
        $page->totalPages->shouldBe(2);
    }
}

<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Builder\HasPrev;
use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use Makedo\Paginator\Strategy\Skip\Skip;
use PhpSpec\ObjectBehavior;

class HasPrevSpec extends ObjectBehavior
{
    function let(Skip $skip)
    {
        $this->beConstructedWith($skip);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HasPrev::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_sets_has_prev_as_has_skip(Skip $skip, Page $page)
    {
        $skip->hasSkip()->willReturn(true);

        $page = $page->getWrappedObject();

        $page = $this->build($page);

        $page->hasPrev->shouldBe(true);
    }

}

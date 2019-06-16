<?php

namespace spec\Makedo\Paginator\Strategy\Skip;

use InvalidArgumentException;
use Makedo\Paginator\Strategy\Skip\ByOffset;
use Makedo\Paginator\Strategy\Skip\Skip;
use PhpSpec\ObjectBehavior;

class ByOffsetSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(10, 2);

        $this->shouldHaveType(ByOffset::class);
        $this->shouldImplement(Skip::class);
    }

    function it_has_skip_when_current_page_more_than_1()
    {
        $currentPage = 2;
        $perPage = 10;
        $this->beConstructedWith($perPage, $currentPage);

        $this->hasSkip()->shouldBe(true);
    }

    function it_has_no_skip_when_current_page_equals_1()
    {
        $currentPage = 1;
        $perPage = 10;
        $this->beConstructedWith($perPage, $currentPage);

        $this->hasSkip()->shouldBe(false);
    }

    function it_counts_skip()
    {
        $currentPage = 10;
        $perPage = 2;
        $this->beConstructedWith($perPage, $currentPage);

        $this->countSkip()->shouldBe(($currentPage - 1) * $perPage);
    }
}

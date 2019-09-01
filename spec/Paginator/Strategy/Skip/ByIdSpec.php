<?php

namespace spec\Makedo\Paginator\Strategy\Skip;

use Makedo\Paginator\Strategy\Skip\ById;
use Makedo\Paginator\Strategy\Skip\Skip;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ByIdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(10);
        $this->shouldHaveType(ById::class);
        $this->shouldImplement(Skip::class);
    }

    function it_has_skip_when_id_is_not_empty()
    {
        $this->beConstructedWith(1);
        $this->hasSkip()->shouldBe(true);
    }

    function it_has_no_skip_when_id_is_zero()
    {
        $this->beConstructedWith(0);
        $this->hasSkip()->shouldBe(false);
        $this->countSkip()->shouldBe(0);
    }

    function it_counts_skip()
    {
        $this->beConstructedWith(10);
        $this->countSkip()->shouldBe(10);
    }
}

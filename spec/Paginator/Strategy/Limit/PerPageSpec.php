<?php

namespace spec\Makedo\Paginator\Strategy\Limit;

use Makedo\Paginator\Strategy\Limit\Limit;
use Makedo\Paginator\Strategy\Limit\PerPage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PerPageSpec extends ObjectBehavior
{
    const PER_PAGE = 10;

    function it_is_initializable()
    {
        $this->shouldHaveType(PerPage::class);
        $this->shouldImplement(Limit::class);
    }

    function let()
    {
        $this->beConstructedWith(self::PER_PAGE);
    }

    public function it_counts_limit_as_per_page()
    {
        $this->countLimit()->shouldBe(self::PER_PAGE);
    }
}

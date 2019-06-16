<?php

namespace spec\Makedo\Paginator\Strategy\Next;

use Makedo\Paginator\Strategy\Next\ItemsCount;
use Makedo\Paginator\Strategy\Next\Next;
use PhpSpec\ObjectBehavior;

class ItemsCountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(1,1);
        $this->shouldHaveType(ItemsCount::class);
        $this->shouldImplement(Next::class);
    }

    function it_has_next_when_count_of_items_more_than_per_page()
    {
        $itemsCount = 10;
        $perPage = 9;

        $this->beConstructedWith($itemsCount, $perPage);
        $this->hasNext()->shouldBe(true);
    }

    function it_has_no_next_when_count_of_items_less_or_equals_per_page()
    {
        $itemsCount = 9;
        $perPage = 9;

        $this->beConstructedWith($itemsCount, $perPage);
        $this->hasNext()->shouldBe(false);
    }
}

<?php

namespace spec\Makedo\Paginator\Counter;

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Counter\Counter;
use PhpSpec\ObjectBehavior;

class CallableCounterSpec extends ObjectBehavior
{
    const COUNT = 1;

    function it_is_initializable()
    {
        $this->shouldHaveType(CallableCounter::class);
        $this->shouldImplement(Counter::class);

    }

    function let()
    {
        $counter = function() {
            return self::COUNT;
        };

        $this->beConstructedWith($counter);
    }

    function it_calls_counter_function_and_returns_it_value()
    {
        $this->count()->shouldBe(self::COUNT);
    }
}

<?php

namespace spec\Makedo\Paginator\Loader;

use Makedo\Paginator\Loader\CallableLoader;
use Makedo\Paginator\Loader\Loader;
use PhpSpec\ObjectBehavior;
use Test\Makedo\CallableMock;


class CallableLoaderSpec extends ObjectBehavior
{
    const DATA = [];

    function it_is_initializable()
    {
        $this->shouldHaveType(CallableLoader::class);
        $this->shouldImplement(Loader::class);
    }

    function let(CallableMock $loader)
    {
        $loader->__invoke()->willReturn(self::DATA);

        $this->beConstructedWith($loader);
    }

    function it_calls_loader_function_and_returns_it_value(CallableMock $loader)
    {
        $this->load()->shouldBe(self::DATA);

        $loader->__invoke()->shouldHaveBeenCalled();
    }
}

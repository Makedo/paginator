<?php

namespace spec\Makedo\Paginator\Loader;

use Makedo\Paginator\Loader\CallableLoader;
use Makedo\Paginator\Loader\Loader;
use PhpSpec\ObjectBehavior;
use spec\Makedo\Paginator\CallableMock;

class CallableLoaderSpec extends ObjectBehavior
{
    const DATA = [];
    const LIMIT = 10;
    const OFFSET = 50;

    function it_is_initializable()
    {
        $this->shouldHaveType(CallableLoader::class);
        $this->shouldImplement(Loader::class);
    }

    function let()
    {
        $this->beConstructedWith(function() {return [];});
    }

    function it_calls_loader_function_and_returns_result(CallableMock $loader)
    {
        $loader->__invoke(self::LIMIT, self::OFFSET)->willReturn(self::DATA);

        $result = $this->load(self::LIMIT, self::OFFSET);

        $result->shouldIterateAs(self::DATA);
    }
}

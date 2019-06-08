<?php

namespace spec\Makedo\Paginator\Loader;

use Makedo\Paginator\Loader\CallableLoader;
use Makedo\Paginator\Loader\Loader;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;
use Test\Makedo\CallableMock;

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

    function it_calls_loader_function_and_creates_result_object(CallableMock $loader)
    {
        $loader->__invoke(self::LIMIT, self::OFFSET)->willReturn(self::DATA);

        $result = $this->load(self::LIMIT, self::OFFSET);

        $result->shouldBeAnInstanceOf(Result::class);

        $result->shouldIterateAs(self::DATA);
    }

    function it_calls_loader_function_and_returns_result(CallableMock $loader)
    {
        $result = Result::fromIterable([]);

        $loader->__invoke(self::LIMIT, self::OFFSET)->willReturn($result);

        $result = $this->load(self::LIMIT, self::OFFSET);

        $result->shouldBe($result);
    }
}

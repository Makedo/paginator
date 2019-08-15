<?php

namespace spec\Makedo\Paginator\Loader;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Makedo\Paginator\Loader\Result;
use PhpSpec\ObjectBehavior;

class ResultSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(new ArrayIterator([]), 0);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Result::class);
        $this->shouldImplement(IteratorAggregate::class);
        $this->shouldImplement(Countable::class);
    }

    function it_iterates_over_array()
    {
        $data = [1, 2, 3, 4, 5];
        $count = count($data);
        $this->beConstructedThrough('fromIterable', [$data]);

        $this->getIterator()->shouldIterateAs($data);
        $this->count()->shouldBe($count);
    }

    function it_iterates_over_array_with_limit()
    {
        $data = [1, 2, 3, 4, 5];
        $limit = 4;
        $this->beConstructedThrough('fromIterable', [$data, $limit]);

        $this->getIterator()->shouldIterateAs([1, 2, 3, 4]);
        $this->count()->shouldBe(count($data));
    }

    function it_iterates_over_iterator()
    {
        $data = [1, 2, 3, 4, 5];
        $iterator = new ArrayIterator($data);
        $count = count($data);
        $this->beConstructedThrough('fromIterable', [$iterator]);

        $this->getIterator()->shouldIterateAs($data);
        $this->count()->shouldBe($count);
    }

    function it_iterates_over_iterator_with_limit()
    {
        $data = [1, 2, 3, 4, 5];
        $iterator = new ArrayIterator($data);
        $limit = 4;
        $this->beConstructedThrough('fromIterable', [$iterator, $limit]);

        $this->getIterator()->shouldIterateAs([1, 2, 3, 4]);
        $this->count()->shouldBe(count($data));
    }
}

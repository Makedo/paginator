<?php

namespace spec\Makedo\Paginator\Loader;

use ArrayIterator;
use Countable;
use Iterator;
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
        $data = [1,2,3,4,5];
        $this->beConstructedThrough('fromIterable', [$data]);

        $this->getIterator()->shouldIterateAs(new ArrayIterator($data));
        $this->count()->shouldBe(count($data));
    }

    function it_iterates_over_traversable()
    {
        $data = [1,2,3,4,5];
        $traversable = new ArrayIterator($data);
        $this->beConstructedThrough('fromIterable', [$traversable]);

        $this->getIterator()->shouldIterateAs(new ArrayIterator($data));
        $this->count()->shouldBe(count($data));
    }

    function it_rewinds_iterator_after_construct(Iterator $iterator)
    {
        $this->beConstructedThrough('fromIterable', [$iterator]);

        $this->getIterator()->shouldBe($iterator);

        $iterator->rewind()->shouldHaveBeenCalled();
    }
}

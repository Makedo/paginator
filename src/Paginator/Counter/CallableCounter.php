<?php

namespace Makedo\Paginator\Counter;

class CallableCounter implements Counter
{
    /**
     * @var callable
     */
    private $counter;

    public function __construct(callable $counter)
    {
        $this->counter = $counter;
    }

    public function count(): int
    {
        return 1;
    }

}

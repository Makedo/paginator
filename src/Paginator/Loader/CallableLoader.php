<?php

namespace Makedo\Paginator\Loader;

class CallableLoader implements Loader
{
    /**
     * @var callable
     */
    private $loader;

    public function __construct(callable $loader)
    {
        $this->loader = $loader;
    }

    public function load(int $limit, int $offset): Result
    {
        $result = call_user_func($this->loader, $limit, $offset);

        if ($result instanceof Result) {
            return $result;
        }

        return Result::fromIterable($result);
    }
}

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

    public function load(int $limit, ?int $skip): Result
    {
        $result = call_user_func($this->loader, $limit, $skip);

        if ($result instanceof Result) {
            return $result;
        }

        return Result::fromIterable($result);
    }
}

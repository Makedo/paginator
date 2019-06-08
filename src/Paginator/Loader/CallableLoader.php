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

    public function load(): iterable
    {
        return call_user_func($this->loader);
    }
}

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

    public function load(int $limit, ?int $skip): iterable
    {
        $result = call_user_func($this->loader, $limit, $skip);
        return $result;
    }
}

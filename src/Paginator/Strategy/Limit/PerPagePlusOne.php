<?php

namespace Makedo\Paginator\Strategy\Limit;

class PerPagePlusOne implements Limit
{
    /**
     * @var int
     */
    private $perPage;

    public function __construct(int $perPage)
    {
        $this->perPage = $perPage;
    }

    public function countLimit(): int
    {
        return $this->perPage + 1;
    }
}

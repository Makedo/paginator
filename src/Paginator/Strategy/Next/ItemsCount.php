<?php

namespace Makedo\Paginator\Strategy\Next;

class ItemsCount implements Next
{
    /**
     * @var int
     */
    private $itemsCount;

    /**
     * @var int
     */
    private $perPage;

    public function __construct(int $itemsCount, int $perPage)
    {
        $this->itemsCount = $itemsCount;
        $this->perPage = $perPage;
    }

    public function hasNext(): bool
    {
        return $this->itemsCount > $this->perPage;
    }
}

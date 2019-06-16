<?php

namespace Makedo\Paginator\Strategy\Skip;

class ByOffset implements Skip
{
    /**
     * @var int
     */
    private $perPage;
    /**
     * @var int
     */
    private $currentPage;

    public function __construct(int $perPage, int $currentPage = 1)
    {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    public function hasSkip(): bool
    {
        return $this->currentPage > 1;
    }

    public function countSkip(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }
}

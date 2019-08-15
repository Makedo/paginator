<?php

namespace Makedo\Paginator\Strategy\Skip;


class ById implements Skip
{
    /**
     * @var int|null
     */
    private $id;

    public function __construct(?int $id)
    {
        if ($id < 0) {
            $id = 0;
        }

        $this->id = $id;
    }

    public function hasSkip(): bool
    {
        return !empty($this->id);
    }

    public function countSkip(): int
    {
        return (int) $this->id;
    }
}

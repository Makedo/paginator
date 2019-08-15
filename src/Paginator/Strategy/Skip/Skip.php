<?php

namespace Makedo\Paginator\Strategy\Skip;

interface Skip
{
    public function hasSkip(): bool;
    public function countSkip(): int;
}
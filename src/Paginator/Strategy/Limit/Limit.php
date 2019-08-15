<?php

namespace Makedo\Paginator\Strategy\Limit;

interface Limit
{
    public function countLimit(): int;
}
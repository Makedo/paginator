<?php

namespace Makedo\Paginator\Loader;

interface Loader
{
    public function load(int $limit, ?int $skip): iterable;
}
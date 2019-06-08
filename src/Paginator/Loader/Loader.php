<?php

namespace Makedo\Paginator\Loader;

interface Loader
{
    public function load(): iterable;
}
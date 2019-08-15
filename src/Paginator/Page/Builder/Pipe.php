<?php

namespace Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Page;

interface Pipe
{
    public function build(Page $page): Page;
}

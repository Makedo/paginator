<?php

namespace Makedo\Paginator;

use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;

class Paginator
{
    /**
     * @var Pipe[]
     */
    private $pipeline = [];

    public function __construct(Pipe ...$pipeline)
    {
        $this->pipeline = $pipeline;
    }

    public function addPipe(Pipe $pipe): Paginator
    {
        array_push($this->pipeline, $pipe);
        return $this;
    }

    public function paginate(): Page
    {
        $page = new Page();

        foreach ($this->pipeline as $pipe) {
            $page = $pipe->build($page);
        }

        return $page;
    }
}

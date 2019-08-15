<?php

namespace spec\Makedo\Paginator\Page\Builder;

use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Builder\Init;
use Makedo\Paginator\Page\Page;
use PhpSpec\ObjectBehavior;

class InitSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(1, 2);
        $this->shouldHaveType(Init::class);
        $this->shouldImplement(Pipe::class);
    }

    function it_builds_page_with_init_parameters(Page $page)
    {
        $perPage = 10;
        $currentPage = 2;

        $this->beConstructedWith($perPage, $currentPage);

        $page = $this->build($page);

        $page->perPage->shouldBe($perPage);
        $page->currentPage->shouldBe($currentPage);
    }
}

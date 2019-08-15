<?php


namespace spec\Makedo\Paginator;


use Makedo\Paginator\Page\Builder\Pipe;
use Makedo\Paginator\Page\Page;
use Makedo\Paginator\Paginator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaginatorSpec extends ObjectBehavior
{
    const PER_PAGE = 10;

    function let(Pipe $pipe1)
    {
        $this->beConstructedWith($pipe1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Paginator::class);
    }

    public function it_creates_page_object_and_runs_it_over_pipes(Pipe $pipe1, Pipe $pipe2, Page $pageMock)
    {
        $pageObject = $pageMock->getWrappedObject();

        $pipe1->build(Argument::type(Page::class))
            ->willReturn($pageObject)
            ->shouldBeCalled()
        ;

        $pipe2->build($pageObject)
            ->willReturn($pageObject)
            ->shouldBeCalled()
        ;

        $this->addPipe($pipe2);
        $page = $this->paginate();

        $page->shouldBe($pageObject);
    }
}
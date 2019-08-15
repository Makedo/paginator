<?php

namespace Makedo\Paginator;

use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Loader\Loader;

use Makedo\Paginator\Page\Builder\Init;
use Makedo\Paginator\Page\Builder\LoadItems;
use Makedo\Paginator\Page\Builder\HasNextByItems;
use Makedo\Paginator\Page\Builder\HasNextByPages;
use Makedo\Paginator\Page\Builder\CountTotal;

use Makedo\Paginator\Strategy\Limit\PerPage;
use Makedo\Paginator\Strategy\Limit\PerPagePlusOne;
use Makedo\Paginator\Strategy\Skip\ById;
use Makedo\Paginator\Strategy\Skip\ByOffset;
use Makedo\Paginator\Strategy\Skip\Skip;
use RuntimeException;

class PaginatorBuilder
{
    const DEFAULT_PER_PAGE = 10;
    
    const SKIP_BY_OFFSET = 'offset';
    const SKIP_BY_ID     = 'id';

    /**
     * @var int
     */
    private $perPage;

    /**
     * @var Skip
     */
    private $skipStrategy = self::SKIP_BY_OFFSET;

    /**
     * @var ?int
     */
    private $id;

    public function __construct(int $perPage = self::DEFAULT_PER_PAGE)
    {
        $this->perPage($perPage);
    }

    public function perPage(int $perPage): self
    {
        if ($perPage <= 0) {
            $perPage = self::DEFAULT_PER_PAGE;
        }

        $this->perPage = $perPage;
        return $this;
    }

    public function skipById(?int $id): self
    {
        $this->skipStrategy = self::SKIP_BY_ID;
        $this->id = $id;
        
        return $this;
    }
    
    public function skipByOffset(): self
    {
        $this->skipStrategy = self::SKIP_BY_OFFSET;
        return $this;
    }

    public function build(int $currentPage, Loader $loader, ?Counter $counter = null): Paginator
    {
        $skipStrategy = $this->createSkipStrategy($currentPage);

        $paginator = new Paginator();

        if ($counter) {
            $limitStrategy = new PerPage($this->perPage);
            $paginator
                ->addPipe(new Init($this->perPage, $currentPage))
                ->addPipe(new LoadItems($loader, $limitStrategy, $skipStrategy))
                ->addPipe(new CountTotal($counter))
                ->addPipe(new HasNextByPages())
            ;
        } else {
            $limitStrategy = new PerPagePlusOne($this->perPage);
            $paginator
                ->addPipe(new Init($this->perPage, $currentPage))
                ->addPipe(new LoadItems($loader, $limitStrategy, $skipStrategy))
                ->addPipe(new HasNextByItems())
            ;
        }

        return $paginator;
    }
    
    private function createSkipStrategy(int $currentPage): Skip
    {
        switch ($this->skipStrategy) {
            case self::SKIP_BY_ID:
                return new ById($this->id);
                
            case self::SKIP_BY_OFFSET:
                return new ByOffset($this->perPage, $currentPage);
        }
        
        throw new RuntimeException('Invalid skip strategy.');
    }
}

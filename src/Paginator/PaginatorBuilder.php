<?php

namespace Makedo\Paginator;

use Makedo\Paginator\Counter\Counter;
use Makedo\Paginator\Loader\Loader;

use Makedo\Paginator\Page\Builder\Init;
use Makedo\Paginator\Page\Builder\LoadItems;
use Makedo\Paginator\Page\Builder\HasNextByItemsCount;
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
    private $perPage = self::DEFAULT_PER_PAGE;

    /**
     * @var string
     */
    private $skipStrategy = self::SKIP_BY_OFFSET;

    /**
     * @var ?int
     */
    private $currentPage;

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

    public function currentPage(int $currentPage): self
    {
        if ($currentPage <= 0) {
            $currentPage = 1;
        }

        $this->currentPage = $currentPage;
        return $this;
    }

    public function skipById(?int $id): self
    {
        $this->skipStrategy = self::SKIP_BY_ID;
        $this->id = $id;
        
        return $this;
    }
    
    public function skipByOffset(int $currentPage): self
    {
        $this->skipStrategy = self::SKIP_BY_OFFSET;
        $this->currentPage($currentPage);

        return $this;
    }

    public function build(Loader $loader, ?Counter $counter = null): Paginator
    {
        $skipStrategy  = $this->createSkipStrategy();

        if ($counter && $this->currentPage) {
            $limitStrategy = new PerPage($this->perPage);
            $next = new HasNextByPages();
        } else {
            $limitStrategy = new PerPagePlusOne($this->perPage);
            $next = new HasNextByItemsCount();
        }

        $paginator = new Paginator();
        $paginator
            ->addPipe(new Init($this->perPage, $this->currentPage))
            ->addPipe(new LoadItems($loader, $limitStrategy, $skipStrategy));

        if ($counter) {
            $paginator->addPipe(new CountTotal($counter));
        }

        $paginator->addPipe($next);

        return $paginator;
    }
    
    protected function createSkipStrategy(): Skip
    {
        switch ($this->skipStrategy) {
            case self::SKIP_BY_ID:
                return new ById($this->id);
                
            case self::SKIP_BY_OFFSET:
                return new ByOffset($this->perPage, $this->currentPage);
        }
        
        throw new RuntimeException('Invalid skip strategy.');
    }
}

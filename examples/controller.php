<?php

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Loader\CallableLoader;
use Makedo\Paginator\PaginatorBuilder;

class UsersController
{
    private $usersRepo;

    /**
     * @var PaginatorBuilder
     */
    private $paginatorBuilder;

    public function __construct($usersRepo, PaginatorBuilder $paginatorBuilder)
    {
        $this->usersRepo = $usersRepo;
        $this->paginatorBuilder = $paginatorBuilder;
    }

    /**
     * @param array $filters
     * @param int   $currentPage
     * @param int   $lastIdOnPreviousPage  for 1st page its 0 or just empty
     *
     * @return string
     */
    public function fetchUsersAction(array $filters, int $currentPage, int $lastIdOnPreviousPage)
    {
        $loader = new CallableLoader(function (int $limit, int $skip) use ($filters) {
            return $this->usersRepo->fetchUsers($filters, $limit, $skip);
        });

        $counter = new CallableCounter(function () use ($filters) {
            return $this->usersRepo->count($filters);
        });

        $paginator = $this->paginatorBuilder
            ->skipById($lastIdOnPreviousPage)
            ->currentPage($currentPage)
            ->build($loader, $counter)
        ;

        $page = $paginator->paginate();

        if (0 === $page->items->count()) {
            return 'Empty Page';
        }
    }
}
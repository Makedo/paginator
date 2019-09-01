<?php

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Factory\SkipByIdCountableWithCurrentPage;
use Makedo\Paginator\Loader\CallableLoader;
class UsersController
{
    private $usersRepo;

    /**
     * @var SkipByIdCountableWithCurrentPage
     */
    private $paginatorFactory;

    private $view;

    public function __construct($usersRepo, SkipByIdCountableWithCurrentPage $paginatorFactory, $view)
    {
        $this->usersRepo = $usersRepo;
        $this->paginatorFactory = $paginatorFactory;
        $this->view = $view;
    }

    /**
     * @param array $filters
     * @param int   $currentPage
     * @param int   $lastIdOnPreviousPage  for 1st page should be 0
     *
     * @return string
     */
    public function fetchUsersAction(array $filters, int $currentPage, ?int $lastIdOnPreviousPage = 0)
    {
        $loader = new CallableLoader(function (int $limit, int $skip) use ($filters) {
            return $this->usersRepo->fetchUsers($filters, $limit, $skip);
        });

        $counter = new CallableCounter(function () use ($filters) {
            return $this->usersRepo->count($filters);
        });

        $paginator = $this->paginatorFactory->createPaginator(
            $loader, $counter, $lastIdOnPreviousPage, $currentPage
        );

        $page = $paginator->paginate();

        if (0 === $page->items->count()) {
            return 'Empty Page';
        }

        return $this->view->render('users.phtml', [$page]);
    }
}
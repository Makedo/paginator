<?php

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Loader\CallableLoader;
use Makedo\Paginator\PaginatorBuilder;

require "../vendor/autoload.php";

$perPage = 100;
$paginatorBuilder = new PaginatorBuilder($perPage);

$lastIdOnPreviousPage = 34;

$loader = function (int $limit, int $skip): iterable
{
    $pdo = new PDO();
    $stmt = $pdo->prepare('SELECT * FROM users LIMIT :limit where id > id');
    $stmt->execute(['limit' => $limit, 'id' => $skip]);
    return $stmt->fetchAll();
};

$counter = function (): int { //this function should return integer value of total count of all paginated items.
    $pdo = new PDO();
    $stmt = $pdo->prepare('SELECT count(id) FROM users');
    return $stmt->fetch();
};


$page = $paginatorBuilder
    ->skipById($lastIdOnPreviousPage)
//    ->skipByOffset($currentPage) You can use any skip strategy with counter
    ->build(new CallableLoader($loader), new CallableCounter($counter))
    ->paginate()
;

var_dump($page->perPage);
var_dump($page->hasNext);
var_dump($page->hasPrev);
var_dump($page->items->count());
var_dump($page->itemsCount);
foreach ($page->items as $user) {
    var_dump($user);
}

//If you add a counter - these properties of page can be filled.
var_dump($page->total);
var_dump($page->totalPages);
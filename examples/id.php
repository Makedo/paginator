<?php

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


$page = $paginatorBuilder
    ->skipById($lastIdOnPreviousPage)
    //->currentPage($currentPage) here we use skip by id strategy and current page is not required,
    // because in this case we should not count offset. But you still can set current page value. By default its 1.
    ->build(new CallableLoader($loader))
    ->paginate()
;

var_dump($page->perPage);
var_dump($page->currentPage);
var_dump($page->hasNext);
var_dump($page->hasPrev);
var_dump($page->items->count());
foreach ($page->items as $user) {
    var_dump($user);
}
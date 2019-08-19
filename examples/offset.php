<?php

use Makedo\Paginator\Loader\CallableLoader;
use Makedo\Paginator\PaginatorBuilder;

require "../vendor/autoload.php";

$perPage = 100;
$paginatorBuilder = new PaginatorBuilder($perPage);

$currentPage = 2;
$loader = function (int $limit, int $skip): iterable
{
    $pdo = new PDO();
    $stmt = $pdo->prepare('SELECT * FROM users LIMIT :limit OFFSET :offset');
    $stmt->execute(['limit' => $limit, 'offset' => $skip]);
    return $stmt->fetchAll();
};

$page = $paginatorBuilder
    ->currentPage($currentPage)
    ->build(new CallableLoader($loader))
    ->paginate()
;

var_dump($page->currentPage);
var_dump($page->perPage);
var_dump($page->hasNext);
var_dump($page->hasPrev);
var_dump($page->items->count());
var_dump($page->itemsCount);

foreach ($page->items as $user) {
    var_dump($user);
}
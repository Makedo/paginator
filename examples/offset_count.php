<?php

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Factory\FactoryFacade;
use Makedo\Paginator\Loader\CallableLoader;

require "../vendor/autoload.php";

$pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'name', 'password');

$loader = function (int $limit, int $skip) use ($pdo): iterable
{
    $stmt = $pdo->prepare('SELECT * FROM users LIMIT :limit OFFSET :offset');
    $stmt->execute(['limit' => $limit, 'offset' => $skip]);
    return $stmt->fetchAll();
};

$counter = function () use ($pdo): int { //this function should return integer value of total count of items.
    $stmt = $pdo->prepare('SELECT count(id) FROM users');
    return $stmt->fetch();
};


$perPage = 100;
$currentPage = 2;
$factoryFacade = new FactoryFacade();

$page = $factoryFacade
    ->createSkipByOffsetCountable($currentPage)
    ->createPaginator(new CallableLoader($loader), new CallableCounter($counter), $currentPage)
    ->paginate()
;

var_dump($page);
<?php

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Factory\FactoryFacade;
use Makedo\Paginator\Loader\CallableLoader;

require "../vendor/autoload.php";

$pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'name', 'password');

$loader = function (int $limit, int $skip) use ($pdo): iterable
{
    $stmt = $pdo->prepare('SELECT * FROM users where id > :skip LIMIT :limit');
    $stmt->execute(['limit' => $limit, 'skip' => $skip]);
    return $stmt->fetch(\PDO::FETCH_NUM);
};

$counter = function () use ($pdo): int { //this function should return integer value of total count of items.
    $stmt = $pdo->prepare('SELECT count(id) FROM users');
    return $stmt->fetch();
};


$perPage = 100;
$lastIdOnPreviousPage = 34;
$currentPage = 5;
$factoryFacade = new FactoryFacade();

$page = $factoryFacade
    ->createSkipByIdCountableWithCurrentPage($perPage)
    ->createPaginator(
        new CallableLoader($loader),
        new CallableCounter($counter),
        $lastIdOnPreviousPage,
        $currentPage
    )
    ->paginate()
;

var_dump($page);
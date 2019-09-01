<?php

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

$perPage = 100;
$lastIdOnPreviousPage = 34;
$factoryFacade = new FactoryFacade();
$page = $factoryFacade
    ->createSkipById($perPage)
    ->createPaginator(new CallableLoader($loader), $lastIdOnPreviousPage)
    ->paginate()
;

var_dump($page);
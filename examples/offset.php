<?php

use Makedo\Paginator\Factory\FactoryFacade;
use Makedo\Paginator\Loader\CallableLoader;

require "../vendor/autoload.php";

$pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'name', 'password');
$loader = function (int $limit, int $skip) use ($pdo): iterable
{
    $stmt = $pdo->prepare('SELECT * FROM users LIMIT :limit OFFSET :offset');
    $stmt->execute(['limit' => $limit, 'offset' => $skip]);
    return $stmt->fetch(\PDO::FETCH_NUM);
};

$perPage = 100;
$currentPage = 2;
$factoryFacade = new FactoryFacade();

$page = $factoryFacade
    ->createSkipByOffset($perPage)
    ->createPaginator(new CallableLoader($loader), $currentPage)
    ->paginate()
;

var_dump($page);
<?php

use Makedo\Paginator\Counter\CallableCounter;
use Makedo\Paginator\Factory\FactoryFacade;
use Makedo\Paginator\Loader\CallableLoader;

require "../vendor/autoload.php";

$loader = function (int $limit, int $skip): iterable
{
    //    Here is and example of query. For making it work - just return an array

    //    $pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'name', 'password');
    //    $stmt = $pdo->prepare('SELECT * FROM users where id > :skip LIMIT :limit');
    //    $stmt->execute(['limit' => $limit, 'skip' => $skip]);
    //    return $stmt->fetch(\PDO::FETCH_NUM);

    return [['id' => 35, 'name' => 'John Doe'], ['id' => 36, 'name' => 'Jan Kowalski']];
};

$counter = function (): int { //this function should return integer value of total count of items.
    //    Here is and example of query. For making it work - just return an integer value

    //    $pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'name', 'password');
    //    $stmt = $pdo->prepare('SELECT count(id) FROM users');
    //    return $stmt->fetch();

    return 400;
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
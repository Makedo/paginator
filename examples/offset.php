<?php

use Makedo\Paginator\Factory\FactoryFacade;
use Makedo\Paginator\Loader\CallableLoader;

require "../vendor/autoload.php";


$loader = function (int $limit, int $skip): iterable
{
    //    Here is and example of query. For making it work - just return an array

    //    $pdo = new \PDO('mysql:host=localhost;dbname=testdb', 'name', 'password');
    //    $stmt = $pdo->prepare('SELECT * FROM users LIMIT :limit OFFSET :offset');
    //    $stmt->execute(['limit' => $limit, 'offset' => $skip]);
    //    return $stmt->fetch(\PDO::FETCH_NUM);

    return [['id' => 35, 'name' => 'John Doe'], ['id' => 36, 'name' => 'Jan Kowalski']];
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
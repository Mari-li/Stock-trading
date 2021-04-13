<?php

use App\Controllers\StockController;
use App\Models\Wallet;
use App\Repositories\FinnhubRepository;
use App\Repositories\MySQLStockRepository;
use App\Repositories\StockRepository;
use App\Services\stockBuyService;
use App\Services\StockPortfolioService;
use App\Services\StockSellService;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once '../vendor/autoload.php';

session_start();


$container = new League\Container\Container;
$container->add('loader', FilesystemLoader::class)->addArgument('/mnt/c/projects/stock-trading/app/Views/');
$container->add('twig', Environment::class)->addArgument('loader');
$container->add(FinnhubRepository::class, FinnhubRepository::class);
$container->add(StockRepository::class, MySQLStockRepository::class);
$container->add(Wallet::class, Wallet::class);
$container->add(StockBuyService::class, StockBuyService::class)->addArguments
([
    StockRepository::class,
    FinnhubRepository::class
]);
$container->add(StockSellService::class, StockSellService::class)->addArgument(StockRepository::class);
$container->add(StockPortfolioService::class, StockPortfolioService::class)->addArguments
([
    StockRepository::class,
    FinnhubRepository::class
]);
$container->add(StockController::class, StockController::class)->addArguments
([
    StockBuyService::class,
    StockPortfolioService::class,
    StockSellService::class,
    Wallet::class,
    'twig'
]);


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('POST', '/buy', [StockController::class, 'buyStocks']);
    $r->addRoute('GET', '/', [StockController::class, 'showStockPortfolio']);
    $r->addRoute('POST', '/sell', [StockController::class, 'sellStocks']);

});


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;
        echo ($container->get($controller))->$method($vars);
        break;
}

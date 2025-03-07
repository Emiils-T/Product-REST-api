<?php

require_once "vendor/autoload.php";

use App\Controllers\Api\ProductController;
use App\Repository\BookRepository;
use App\Repository\DVDRepository;
use App\Repository\FurnitureRepository;
use App\Repository\ProductRepository;
use Doctrine\DBAL\DriverManager;


try {
    $connectionParams = include("config/database.php");
    $conn = DriverManager::getConnection($connectionParams);
} catch (\Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database connection error' . ' ' . $e->getMessage()]);
    exit;
}

$schemaManager = $conn->createSchemaManager();

$productRepository = new ProductRepository($conn);
$productRepository->createTable();

$dvdRepository = new DvdRepository($conn);
$dvdRepository->createTable();

$bookRepository = new BookRepository($conn);
$bookRepository->createTable();

$furnitureRepository = new FurnitureRepository($conn);
$furnitureRepository->createTable();


$container = new DI\Container();
$container->set(
    ProductController::class,
    new ProductController($connectionParams)
);


$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $routes = include('routes.php');
    foreach ($routes as $route) {
        [$method, $url, $controller] = $route;
        $r->addRoute($method, $url, $controller);
    }
});


// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);


$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        var_dump($uri);
        // ... 404 Not Found
        header('Content-Type: application/json');
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        header('Content-Type: application/json');
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Found']);
        break;
    case FastRoute\Dispatcher::FOUND:
        header('Content-Type: application/json');
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        [$controller, $method] = $handler;
        $response = ($container->get($controller))->{$method}(...array_values($vars));
        echo $response;
        break;
}




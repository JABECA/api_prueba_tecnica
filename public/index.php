<?php

declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/validators.php';

$container = new Container();
$settings  = require __DIR__ . '/../src/db.php';

foreach ($settings as $key => $value) {
    $container->set($key, $value);
}

AppFactory::setContainer($container);
$app = AppFactory::create();


$basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$app->setBasePath($basePath);


// Error middleware para DEV
// $app->addErrorMiddleware(
//     $container->get('settings')['displayErrorDetails'],
//     true,
//     true
// );
$app->addErrorMiddleware(false, true, true);

// Fuerso JSON por defecto
$app->add(function ($req, $handler) {
    $res = $handler->handle($req);
    return $res->withHeader('Content-Type', 'application/json; charset=utf-8');
});

// CORS básico 
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, OPTIONS');
});

// Registro rutas para los endpoints
$routes = require __DIR__ . '/../src/routes.php';
$routes($app);

$app->run();
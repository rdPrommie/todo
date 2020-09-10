<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$logger = require __DIR__ . '/../app/logger.php';
$logger($container);

AppFactory::setContainer($container);

$app = AppFactory::create();

$views = require __DIR__ . '/../app/views.php';
$views($app);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

$routes = require  __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();
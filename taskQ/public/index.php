<?php

declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\Container;

require __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$settings = require __DIR__ . '/../app/settings.php';
$settings($container);

$connection = require __DIR__ . '/../app/connection.php';
$connection($container);

$logger = require __DIR__ . '/../app/logger.php';
$logger($container);

$createDatabase = require __DIR__ . '/../app/createDatabase.php';
$createDatabase($container);

AppFactory::setContainer($container);

$app = AppFactory::create();

$twigProcessor = require __DIR__ . '/../app/twigProcessor.php';
$twigProcessor($container);

$views = require __DIR__ . '/../app/views.php';
$views($app);

$middleware = require __DIR__ . '/../app/middleware.php';
$middleware($app);

function arrayConverter(array &$array) {
    $tasksArray = array();
    for($i=0; $i<=sizeof($array)-1; $i++) {
        $tasksArray['tasks'][$i] = array(
            "id" => $array[$i]["ID"],
            "text" => $array[$i]["Task"]
        );
    }
    return $tasksArray;
}

$routes = require  __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();


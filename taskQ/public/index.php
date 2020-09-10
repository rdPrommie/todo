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

/*$table = "{$container->get('settings')['connection']['dbname']}.users";
$columns = "ID INTEGER (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, Name VARCHAR (55) NOT NULL, Email VARCHAR (55) NOT NULL";
$container->get('connection')->exec("CREATE TABLE IF NOT EXISTS {$table} ({$columns})");

$sql = "INSERT INTO db.`users` (name, email) VALUES ('Julies', 'julia@asdf.com')";

if($container->get('connection')->exec($sql) === true) {
    echo "DB connected cool";
} else {
    echo "ERROR: {$sql} - {$container->get('connection')->error}";
}*/

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
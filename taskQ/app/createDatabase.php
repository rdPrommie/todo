<?php

declare(strict_types=1);

use DI\Container;

return function(Container $container) {
    $table = "{$container->get('settings')['connection']['dbname']}.tasks";
    $columns = "ID INTEGER (11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                Task VARCHAR (255) NOT NULL";
    $container->get('connection')->exec("CREATE TABLE IF NOT EXISTS {$table} ({$columns})");

    if(!$container->get('connection')) {
        echo "ERROR: {$container->get('connection')->error}";
    }
};

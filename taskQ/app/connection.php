<?php

declare(strict_types=1);

use DI\Container;

return function (Container $container) {
    $container->set('connection', function() use ($container) {
        $connection = $container->get('settings')['connection'];

        $host = $connection['host'];
        $dbname = $connection['db'];
        $dbuser = $connection['dbuser'];
        $dbpass = $connection['dbpass'];

        try {
            $connection = new PDO("mysql:host={$host};dbname={$dbname}", $dbuser, $dbpass);
            $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $connection;
    });
};
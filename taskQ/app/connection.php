<?php

declare(strict_types=1);

use DI\Container;

return function (Container $container) {
    $container->set('connection', function() use ($container) {
        $connection = $container->get('settings')['connection'];

        $host = $connection['host'];
        $dbname = $connection['dbname'];
        $dbuser = $connection['dbuser'];
        $dbpass = $connection['dbpass'];

        try {
            $connection = new PDO("mysql:dbname={$dbname};host=127.0.0.1", $dbuser, $dbpass);
            $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

        return $connection;
    });
};
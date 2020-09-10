<?php

declare(strict_types=1);

use DI\Container;
use Monolog\Logger;

return function(Container $container) {
  $container->set('settings', function() {
     return [
         'name' => 'taskQueue',
         'displayErrorDetails' => true,
         'logErrorDetails' => true,
         'logErrors' => true,
         'logger' => [
            'name' => 'taskQApp',
             'path' => __DIR__ . '/../logs/app.log',
             'level' => Logger::DEBUG,
         ],
         'views' => [
            'path' => __DIR__ . '/../src/Views',
             'settings' => ['cache' => false],
         ],
         'connection' => [
             'host' => 'db',
             'dbname' => 'db',
             'dbuser' => 'user',
             'dbpass' => 'secret'
         ],
     ];
  });
};
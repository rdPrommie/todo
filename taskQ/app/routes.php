<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $container = $app->getContainer();

    $app->group('/', function (RouteCollectorProxy $view) {

        $view->map(['GET', 'POST'], '', function($request, $response, $args) {
            $tasks = array('');
            if($this->get('connection')) {
                $query = $this->get('connection')->prepare("SELECT * FROM db.`tasks`");
                $query->execute();
                $tasks = $query->fetchAll();
                $tasks = arrayConverter($tasks);
            }
            return $this->get('view')->render($response, 'index.twig', $tasks);
        });

    })->add($container->get('viewMiddleware'));
};

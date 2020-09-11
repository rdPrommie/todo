<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as RequestInterface;



return function (App $app) {
    $container = $app->getContainer();

    $app->group('/', function (RouteCollectorProxy $view) {

        $view->map(['GET', 'POST'], '', function($request, $response, $args) {
            $tasks = array('error');
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


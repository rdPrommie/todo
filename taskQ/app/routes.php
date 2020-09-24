<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {

    $app->get('/todo/api/', function (Request $request, Response $response, array $args) {
        //get all tasks from database
        try {
            $tasks = array('');
            if($this->get('connection')) {
                $query = $this->get('connection')->prepare("SELECT * FROM db.`tasks`");
                $query->execute();
                $tasks = $query->fetchAll();
                $tasks = arrayConverter($tasks);
            }
        } catch (Exception $e) {
            $tasks['status'] = '400' . $e;
        }
        $tasks['status'] = '200';
        echo json_encode($tasks);
        return $response;
    });

    $app->post('/todo/api/addtask={task}', function(Request $request, Response $response, array $args) {
        //add task to the database
        try {
            if(isset($args['task']) && strlen($args['task']) > 0) {
                $task = $args['task'];
                $query = $this->get('connection')->prepare("INSERT INTO db.`tasks` (task) VALUES ('$task')");
                $query->execute();
                $tasks = $query->fetchAll();
            }
        } catch (Exception $e) {
            $tasks['status'] = '400' . $e;
        }
        $tasks['status'] = '200';
        return $response;
    });

    $app->post('/todo/api/deltask={task_id}', function(Request $request, Response $response, array $args) {
        //del task from the database
        try {
            if(isset($args['task_id']) && strlen($args['task_id']) > 0) {
                $id = $args['task_id'];
                $query = $this->get('connection')->prepare("DELETE FROM db.`tasks` WHERE id=" . $id);
                $query->execute();
                $tasks = $query->fetchAll();
            }
        } catch (Exception $e) {
            $tasks['status'] = '400' . $e;
        }
        $tasks['status'] = '200';
        return $response;
    });
};

function arrayConverter(array &$array) {
    $tasksArray = array();
    for($i=0; $i<=sizeof($array)-1; $i++) {
        $tasksArray['tasks'][$i] = array(
            "id" => $array[$i]["ID"],
            "task" => $array[$i]["Task"]
        );
    }
    return $tasksArray;
}
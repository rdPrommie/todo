<?php

declare(strict_types=1);

use DI\Container;

return function(Container $container) {
    if (isset($_POST['submit'])) {

        if (!empty($_POST['task'])) {
            $task = $_POST['task'];
            $query = "INSERT INTO db.`tasks` (task) VALUES ('$task')";

            if($container->get('connection')) {
                $container->get('connection')->exec($query);
                header('location: index.php');
            } else {
                echo 'error';
            }
        }
    }

    if (isset($_GET['del_task'])) {
        $id = $_GET['del_task'];

        $query = "DELETE FROM db.`tasks` WHERE id=" . $id;

        if($container->get('connection')) {
            $container->get('connection')->exec($query);
            header('location: index.php');
        } else {
            echo 'error';
        }
    }
};


<?php

declare(strict_types=1);

use Slim\App;
use App\Application\Middleware\BeforeMiddleware;
use App\Application\Middleware\AfterMiddleware
    ;

return function (App $app) {
    $settings = $app->getContainer()->get('settings');
    $app->addErrorMiddleware($settings['displayErrorDetails'], $settings['logErrors'], $settings['logErrorDetails']);
    $app->add(AfterMiddleware::class);
    $app->add(BeforeMiddleware::class);
};

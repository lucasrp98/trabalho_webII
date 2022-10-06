<?php
declare(strict_types=1);

use App\Application\Middleware\Layer1;
use App\Application\Middleware\Layer2;
use App\Application\Middleware\SessionMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(SessionMiddleware::class);
};

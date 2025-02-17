<?php

use App\Controller\DocController;
use Slim\App;

return function (App $app) {
    $app->get('/doc', [DocController::class, 'getDocs']);
};

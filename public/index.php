<?php

use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\ResponseFactory;

require __DIR__ . '/../vendor/autoload.php';

// Criar o app
AppFactory::setResponseFactory(new ResponseFactory());
$app = AppFactory::create();

// Registrar as rotas corretamente
$routes = require __DIR__ . '/../src/Routes/ProdutoRoutes.php';
$routes($app);  // <-- Aqui está o erro! Agora estamos chamando a função corretamente.

// Middleware para lidar com erros
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Rodar a aplicação
$app->run();

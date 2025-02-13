<?php

use Slim\Factory\AppFactory;
use App\Routes\ProdutoRoutes;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Middleware para lidar com erros
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Registrar as rotas de produto
$produtoRoutes = new ProdutoRoutes($app);
$produtoRoutes->register();

// Rodar a aplicação
$app->run();

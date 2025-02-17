<?php

namespace App\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $app->group('/produtos', function (RouteCollectorProxy $group) {
        $group->get('', 'App\Controllers\ProdutoController:listarProdutos');
        $group->get('/{id}', 'App\Controllers\ProdutoController:obterProduto');
        $group->post('', 'App\Controllers\ProdutoController:criarProduto');
        $group->delete('/{id}', 'App\Controllers\ProdutoController:excluirProduto');
    });

    // Rota para servir a documentação Swagger
    $app->get('/doc', function ($request, $response) {
        $swaggerFile = __DIR__ . '/../../public/swagger/index.html';

        if (!file_exists($swaggerFile)) {
            $response->getBody()->write("Arquivo index.html não encontrado.");
            return $response->withHeader('Content-Type', 'text/plain')->withStatus(404);
        }

        // Lendo o conteúdo do arquivo e retornando corretamente
        $response->getBody()->write(file_get_contents($swaggerFile));
        return $response->withHeader('Content-Type', 'text/html');
    });
};

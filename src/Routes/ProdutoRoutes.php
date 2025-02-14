<?php

namespace App\Routes;

use App\Controller\ProdutoController;
use Slim\App;

class ProdutoRoutes
{
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    public function register()
    {
        $controller = new ProdutoController();

        $this->app->get('/produtos', [$controller, 'listarProdutos']);
        $this->app->get('/produtos/{id}', [$controller, 'obterProduto']);
        $this->app->post('/produtos', [$controller, 'criarProduto']);
        $this->app->delete('/produtos/{id}', [$controller, 'excluirProduto']);
    }
}

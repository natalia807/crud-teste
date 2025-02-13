<?php

namespace App\Controllers;

use App\Models\Produto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProdutoController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
    }

    public function listarProdutos(Request $request, Response $response)
    {
        $produtos = $this->produtoModel->getAll();
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function obterProduto(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $produto = $this->produtoModel->getById($id);

        if ($produto) {
            $response->getBody()->write(json_encode($produto));
        } else {
            $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['error' => 'Produto não encontrado']));
        }

        return $response;
    }

    public function criarProduto(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $this->produtoModel->create($data['nome'], $data['preco']);

        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['status' => 'Produto criado com sucesso!']));
        return $response;
    }

    public function excluirProduto(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $this->produtoModel->delete($id);

        $response->getBody()->write(json_encode(['status' => 'Produto deletado com sucesso!']));
        return $response;
    }
}

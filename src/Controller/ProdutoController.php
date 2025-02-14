<?php

namespace App\Controller;

use App\Models\Produto;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @OA\Info(title="My First API", version="0.1")
 */

/**
 * @OA\Info(
 *     title="API de Produtos",
 *     version="1.0",
 *     description="API para gerenciamento de produtos",
 *     @OA\Contact(
 *         name="Natália",
 *         email="nmaite0@gmail.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000",
 *     description="Servidor local"
 * )
 */


class ProdutoController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new Produto();
    }

    /**
 * @OA\Get(
 *     path="/produtos",
 *     summary="Lista todos os produtos",
 *     tags={"Produtos"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de produtos",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Produto"))
 *     )
 * )
 */
    public function listarProdutos(Request $request, Response $response)
    {
        $produtos = $this->produtoModel->getAll();
        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
 * @OA\Get(
 *     path="/produtos",
 *     summary="Lista todos os produtos",
 *     tags={"Produtos"},
 *     @OA\Response(
 *         response=200,
 *         description="Lista de produtos",
 *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Produto"))
 *     )
 * )
 */
 /**
     * @OA\Get(
     *     path="/produtos/{id}",
     *     summary="Obtém um produto",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Produto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
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

    /**
     * Cria um novo produto
     *
     * @OA\Post(
     *     path="/produtos",
     *     summary="Cria um novo produto",
     *     tags={"Produtos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome", "preco"},
     *             @OA\Property(property="nome", type="string"),
     *             @OA\Property(property="preco", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Produto criado com sucesso",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="string"))
     *     )
     * )
     */
    public function criarProduto(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $this->produtoModel->create($data['nome'], $data['preco']);

        $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['status' => 'Produto criado com sucesso!']));
        return $response;
    }

    /**
     * Exclui um produto pelo ID
     *
     * @OA\Delete(
     *     path="/produtos/{id}",
     *     summary="Exclui um produto",
     *     tags={"Produtos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Produto deletado com sucesso",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="string"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Produto não encontrado"
     *     )
     * )
     */
    public function excluirProduto(Request $request, Response $response, $args)
    {
        $id = $args['id'];
        $this->produtoModel->delete($id);

        $response->getBody()->write(json_encode(['status' => 'Produto deletado com sucesso!']));
        return $response;
    }
}

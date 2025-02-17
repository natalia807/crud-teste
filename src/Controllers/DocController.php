<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Generator;

/**
 * Controller para gerar e exibir a documentação Swagger
 */
class DocController
{
    /**
     * @OA\Get(
     *     path="/doc",
     *     summary="Retorna a documentação da API",
     *     tags={"Documentação"},
     *     @OA\Response(
     *         response=200,
     *         description="Documentação OpenAPI em JSON"
     *     )
     * )
     */
    public function getDocs(Request $request, Response $response)
    {
        $openapi = Generator::scan([__DIR__ . "/../"]);
        $json = $openapi->toJson();

        $response->getBody()->write($json);
        return $response->withHeader("Content-Type", "application/json");
    }
}

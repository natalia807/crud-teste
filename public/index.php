<?php
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// Middleware para lidar com erros
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, true, true);

// Conectar com o banco de dados MySQL
$pdo = new PDO('mysql:host=db;dbname=crud_teste', 'root', 'rootpassword');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Rota para listar todos os produtos
$app->get('/produtos', function (Request $request, Response $response) use ($pdo) {
    $stmt = $pdo->query('SELECT * FROM produtos');
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response->getBody()->write(json_encode($produtos));
    return $response->withHeader('Content-Type', 'application/json');
});

// Rota para obter um produto específico
$app->get('/produtos/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = ?');
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        $response->getBody()->write(json_encode($produto));
    } else {
        $response = $response->withStatus(404)->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['error' => 'Produto não encontrado']));
    }

    return $response;
});

// Rota para criar um novo produto
$app->post('/produtos', function (Request $request, Response $response) use ($pdo) {
    $data = json_decode($request->getBody()->getContents(), true);
    $stmt = $pdo->prepare('INSERT INTO produtos (nome, preco) VALUES (?, ?)');
    $stmt->execute([$data['nome'], $data['preco']]);

    $response = $response->withStatus(201)->withHeader('Content-Type', 'application/json');
    $response->getBody()->write(json_encode(['status' => 'Produto criado com sucesso!']));
    return $response;
});

// Rota para excluir um produto
$app->delete('/produtos/{id}', function (Request $request, Response $response, $args) use ($pdo) {
    $id = $args['id'];
    $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([$id]);

    $response->getBody()->write(json_encode(['status' => 'Produto deletado com sucesso!']));
    return $response;
});

$app->run();

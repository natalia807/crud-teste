<?php

namespace App\Models;

use PDO;
use App\Database;

/**
 * @OA\Schema(
 *     schema="Produto",
 *     title="Produto",
 *     description="Modelo de Produto",
 *     @OA\Property(property="id", type="integer", description="ID do produto"),
 *     @OA\Property(property="nome", type="string", description="Nome do produto"),
 *     @OA\Property(property="preco", type="number", format="float", description="Preço do produto")
 * )
 */


class Produto
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function getAll()
    {
        $stmt = $this->db->query('SELECT * FROM produtos');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM produtos WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nome, $preco)
    {
        $stmt = $this->db->prepare('INSERT INTO produtos (nome, preco) VALUES (?, ?)');
        return $stmt->execute([$nome, $preco]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM produtos WHERE id = ?');
        return $stmt->execute([$id]);
    }
}

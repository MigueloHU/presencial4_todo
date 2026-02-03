<?php
declare(strict_types=1);

class Categoria
{
    private PDO $pdo;

    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function all(): array
    {
        $stmt = $this->pdo->query("SELECT id, nombre, imagen FROM tblcategoria ORDER BY nombre");
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT id, nombre, imagen FROM tblcategoria WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }
}

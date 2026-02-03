<?php
declare(strict_types=1);

class Tarea
{
    private PDO $pdo;

    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function hoy(): array
    {
        $sql = "SELECT t.*, c.nombre AS categoria_nombre, c.imagen AS categoria_imagen
                FROM tbltareas t
                JOIN tblcategoria c ON c.id = t.cat_id
                WHERE t.fecha = CURDATE()
                ORDER BY t.hora ASC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO tbltareas (fecha, hora, titulo, imagen, descripcion, prioridad, lugar, cat_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['fecha'], $data['hora'], $data['titulo'], $data['imagen'],
            $data['descripcion'], $data['prioridad'], $data['lugar'], $data['cat_id']
        ]);
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT t.*, c.nombre AS categoria_nombre, c.imagen AS categoria_imagen
                FROM tbltareas t
                JOIN tblcategoria c ON c.id = t.cat_id
                WHERE t.id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE tbltareas
                SET fecha=?, hora=?, titulo=?, imagen=?, descripcion=?, prioridad=?, lugar=?, cat_id=?
                WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $data['fecha'], $data['hora'], $data['titulo'], $data['imagen'],
            $data['descripcion'], $data['prioridad'], $data['lugar'], $data['cat_id'],
            $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM tbltareas WHERE id=?");
        return $stmt->execute([$id]);
    }

    public function buscarPorTitulo(string $q): array
    {
        $sql = "SELECT t.*, c.nombre AS categoria_nombre, c.imagen AS categoria_imagen
                FROM tbltareas t
                JOIN tblcategoria c ON c.id = t.cat_id
                WHERE t.titulo LIKE ?
                ORDER BY t.fecha ASC, t.hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $q . '%']);
        return $stmt->fetchAll();
    }

    public function rango(string $ini, string $fin): array
    {
        $sql = "SELECT t.*, c.nombre AS categoria_nombre, c.imagen AS categoria_imagen
                FROM tbltareas t
                JOIN tblcategoria c ON c.id = t.cat_id
                WHERE t.fecha BETWEEN ? AND ?
                ORDER BY t.fecha ASC, t.hora ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$ini, $fin]);
        return $stmt->fetchAll();
    }
}

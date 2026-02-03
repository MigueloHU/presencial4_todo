<?php
declare(strict_types=1);

class Database
{
    private PDO $pdo;

    public function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';

        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            // Prueba rápida con transacción (lo pide el enunciado)
            $this->pdo->beginTransaction();
            $this->pdo->commit();

        } catch (Throwable $e) {
            if (isset($this->pdo) && $this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            die('Error de conexión: ' . $e->getMessage());
        }
    }

    public function pdo(): PDO
    {
        return $this->pdo;
    }
}

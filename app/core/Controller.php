<?php
declare(strict_types=1);

class Controller
{
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    protected function view(string $path, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../views/layout/header.php';
        require __DIR__ . '/../views/' . $path . '.php';
        require __DIR__ . '/../views/layout/footer.php';
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . BASE_URL . $url);
        exit;
    }

    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->redirect('/?c=auth&a=login');
        }
    }
}

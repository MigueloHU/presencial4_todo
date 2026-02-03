<?php
declare(strict_types=1);

class AuthController extends Controller
{
    public function login(): void
    {
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = trim($_POST['usuario'] ?? '');
            $clave   = trim($_POST['clave'] ?? '');

            // Usuario de prueba
            if ($usuario === 'admin' && $clave === '1234') {
                $_SESSION['user'] = $usuario;
                $this->redirect('/?c=tareas&a=hoy');
            } else {
                $error = 'Usuario o contraseña incorrectos';
            }
        }

        $this->view('auth/login', ['error' => $error]);
    }

    public function logout(): void
    {
        session_destroy();
        $this->redirect('/?c=auth&a=login');
    }
}

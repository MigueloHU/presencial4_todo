<?php
declare(strict_types=1);

class App
{
    public function run(): void
    {
        $controller = $_GET['c'] ?? 'tareas';
        $action     = $_GET['a'] ?? 'hoy';

        $controllerName = ucfirst($controller) . 'Controller';
        $file = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($file)) {
            http_response_code(404);
            echo "Controlador no encontrado";
            return;
        }

        require_once $file;

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Clase de controlador no encontrada";
            return;
        }

        $obj = new $controllerName();

        if (!method_exists($obj, $action)) {
            http_response_code(404);
            echo "Acción no encontrada";
            return;
        }

        $obj->$action();
    }
}

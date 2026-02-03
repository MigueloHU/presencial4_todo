<?php
declare(strict_types=1);

require_once __DIR__ . '/../models/Tarea.php';
require_once __DIR__ . '/../models/Categoria.php';

class TareasController extends Controller
{
    public function hoy(): void
    {
        $this->requireLogin();

        $tareaModel = new Tarea($this->db->pdo());
        $tareas = $tareaModel->hoy();

        $this->view('tareas/index', ['tareas' => $tareas]);
    }

    public function crear(): void
    {
        $this->requireLogin();

        $catModel = new Categoria($this->db->pdo());
        $categorias = $catModel->all();

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitización rápida
            $fecha = $_POST['fecha'] ?? '';
            $hora  = $_POST['hora'] ?? '';
            $titulo = trim(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
            $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
            $lugar = trim(filter_input(INPUT_POST, 'lugar', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
            $prioridad = (int)($_POST['prioridad'] ?? 1);
            $cat_id = (int)($_POST['cat_id'] ?? 0);

            // Imagen (de momento texto/ruta; la subida real es ejercicio 2.6)
            $imagen = trim($_POST['imagen'] ?? '');

            if ($fecha === '' || $hora === '' || $titulo === '' || $descripcion === '' || $lugar === '' || $cat_id <= 0) {
                $error = "Faltan datos obligatorios";
            } else {
                $tareaModel = new Tarea($this->db->pdo());
                $ok = $tareaModel->create([
                    'fecha'=>$fecha, 'hora'=>$hora, 'titulo'=>$titulo, 'imagen'=>$imagen,
                    'descripcion'=>$descripcion, 'prioridad'=>$prioridad, 'lugar'=>$lugar, 'cat_id'=>$cat_id
                ]);

                if ($ok) $this->redirect('/?c=tareas&a=hoy');
                $error = "No se pudo insertar";
            }
        }

        $this->view('tareas/form', [
            'modo' => 'crear',
            'categorias' => $categorias,
            'error' => $error,
            'tarea' => null
        ]);
    }

    public function ver(): void
    {
        $this->requireLogin();

        $id = (int)($_GET['id'] ?? 0);
        $tareaModel = new Tarea($this->db->pdo());
        $tarea = $tareaModel->find($id);

        if (!$tarea) { echo "No encontrada"; return; }

        $this->view('tareas/show', ['tarea' => $tarea]);
    }
}

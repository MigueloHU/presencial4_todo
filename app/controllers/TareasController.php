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

    public function buscar(): void
    {
        $this->requireLogin();

        $q = trim($_GET['q'] ?? '');

        $tareas = [];
        if ($q !== '') {
            $tareaModel = new Tarea($this->db->pdo());
            $tareas = $tareaModel->buscarPorTitulo($q);
        }

        $this->view('tareas/buscar', [
            'q' => $q,
            'tareas' => $tareas
        ]);
    }

    public function rango(): void
    {
        $this->requireLogin();

        $inicio = $_GET['inicio'] ?? '';
        $fin    = $_GET['fin'] ?? '';

        $tareas = [];
        $error  = '';

        if ($inicio !== '' && $fin !== '') {
            if ($inicio > $fin) {
                $error = "La fecha de inicio no puede ser mayor que la fecha fin";
            } else {
                $tareaModel = new Tarea($this->db->pdo());
                $tareas = $tareaModel->rango($inicio, $fin);
            }
        }

        $this->view('tareas/rango', [
            'inicio' => $inicio,
            'fin' => $fin,
            'tareas' => $tareas,
            'error' => $error
        ]);
    }



    public function crear(): void
    {
        $this->requireLogin();

        $catModel = new Categoria($this->db->pdo());
        $categorias = $catModel->all();

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitización
            $fecha = $_POST['fecha'] ?? '';
            $hora  = $_POST['hora'] ?? '';
            $titulo = trim(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
            $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
            $lugar = trim(filter_input(INPUT_POST, 'lugar', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
            $prioridad = (int)($_POST['prioridad'] ?? 1);
            $cat_id = (int)($_POST['cat_id'] ?? 0);

            // Imagen (IMPLEMENTAR!)
            $imagenSubida = $this->subirImagenTarea('imagen');
            $imagen = $imagenSubida ?? '';


            if ($fecha === '' || $hora === '' || $titulo === '' || $descripcion === '' || $lugar === '' || $cat_id <= 0) {
                $error = "Faltan datos obligatorios";
            } else {
                $tareaModel = new Tarea($this->db->pdo());
                $ok = $tareaModel->create([
                    'fecha' => $fecha,
                    'hora' => $hora,
                    'titulo' => $titulo,
                    'imagen' => $imagen,
                    'descripcion' => $descripcion,
                    'prioridad' => $prioridad,
                    'lugar' => $lugar,
                    'cat_id' => $cat_id
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

        if (!$tarea) {
            echo "No encontrada";
            return;
        }

        $this->view('tareas/show', ['tarea' => $tarea]);
    }

    public function editar(): void
    {
        $this->requireLogin();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/?c=tareas&a=hoy');
        }

        $tareaModel = new Tarea($this->db->pdo());
        $tarea = $tareaModel->find($id);

        if (!$tarea) {
            $this->redirect('/?c=tareas&a=hoy');
        }

        $catModel = new Categoria($this->db->pdo());
        $categorias = $catModel->all();

        $this->view('tareas/form', [
            'modo' => 'editar',
            'categorias' => $categorias,
            'error' => '',
            'tarea' => $tarea
        ]);
    }

    public function modificar(): void
    {
        $this->requireLogin();

        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $this->redirect('/?c=tareas&a=hoy');
        }

        $error = '';

        // Introduce los datos
        $fecha = $_POST['fecha'] ?? '';
        $hora  = $_POST['hora'] ?? '';
        $titulo = trim(filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
        $descripcion = trim(filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
        $lugar = trim(filter_input(INPUT_POST, 'lugar', FILTER_SANITIZE_SPECIAL_CHARS) ?? '');
        $prioridad = (int)($_POST['prioridad'] ?? 1);
        $cat_id = (int)($_POST['cat_id'] ?? 0);
        // Imagen
        $tareaModelTmp = new Tarea($this->db->pdo());
        $tareaActual = $tareaModelTmp->find($id);

        $imagenSubida = $this->subirImagenTarea('imagen');
        $imagen = $imagenSubida ?? ($tareaActual['imagen'] ?? '');


        if ($fecha === '' || $hora === '' || $titulo === '' || $descripcion === '' || $lugar === '' || $cat_id <= 0) {
            $error = "Faltan datos obligatorios";
        } else {
            $tareaModel = new Tarea($this->db->pdo());
            $ok = $tareaModel->update($id, [
                'fecha' => $fecha,
                'hora' => $hora,
                'titulo' => $titulo,
                'imagen' => $imagen,
                'descripcion' => $descripcion,
                'prioridad' => $prioridad,
                'lugar' => $lugar,
                'cat_id' => $cat_id
            ]);

            if ($ok) {
                $this->redirect('/?c=tareas&a=hoy');
            }
            $error = "No se pudo modificar";
        }

        // En caso de error vuelve a cargar datos
        $tareaModel = new Tarea($this->db->pdo());
        $tarea = $tareaModel->find($id);

        $catModel = new Categoria($this->db->pdo());
        $categorias = $catModel->all();

        $this->view('tareas/form', [
            'modo' => 'editar',
            'categorias' => $categorias,
            'error' => $error,
            'tarea' => $tarea
        ]);
    }


    public function eliminar(): void
    {
        $this->requireLogin();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            $this->redirect('/?c=tareas&a=hoy');
        }

        $tareaModel = new Tarea($this->db->pdo());
        $tareaModel->delete($id);

        $this->redirect('/?c=tareas&a=hoy');
    }

    private function subirImagenTarea(string $campo): ?string
    {
        if (empty($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
            return null; // no se subió nada
        }

        if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $tmp  = $_FILES[$campo]['tmp_name'];
        $name = $_FILES[$campo]['name'];

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($ext, $permitidas, true)) {
            return null;
        }

        // Nombre único
        $nuevoNombre = 'tarea_' . date('Ymd_His') . '_' . mt_rand(1000, 9999) . '.' . $ext;

        $destinoDir = __DIR__ . '/../../public/images/tareas/';
        if (!is_dir($destinoDir)) {
            mkdir($destinoDir, 0777, true);
        }

        $destino = $destinoDir . $nuevoNombre;

        if (!move_uploaded_file($tmp, $destino)) {
            return null;
        }

        return $nuevoNombre; // guardamos solo el nombre en BD
    }
}

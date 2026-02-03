<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Tareas de hoy</h4>

    <div class="d-flex gap-2">
        <a class="btn btn-dark" href="<?= BASE_URL ?>/?c=tareas&a=crear">
            <i class="bi bi-plus-circle"></i> Añadir tarea
        </a>
        <a class="btn btn-outline-dark" href="<?= BASE_URL ?>/?c=auth&a=logout">
            <i class="bi bi-box-arrow-right"></i> Salir
        </a>
    </div>
</div>

<?php if (empty($tareas)): ?>
    <div class="alert alert-warning">
        No hay tareas para hoy. Crea una para probar el listado (fecha = hoy).
    </div>
<?php endif; ?>

<div class="row g-3">
    <?php foreach ($tareas as $t): ?>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between">
                    <span><b>Fecha/hora:</b> <?= htmlspecialchars($t['fecha']) ?> <?= htmlspecialchars($t['hora']) ?></span>
                    <span><b>Importancia:</b> <?= (int)$t['prioridad'] ?></span>
                </div>

                <div class="card-body d-flex gap-3">
                    <div style="width:70px">
                        <img class="img-fluid rounded"
                            src="<?= BASE_URL ?>/images/categorias/<?= htmlspecialchars($t['categoria_imagen']) ?>"
                            alt="cat">
                    </div>

                    <div class="flex-grow-1">
                        <h5 class="mb-1"><?= htmlspecialchars($t['titulo']) ?></h5>
                        <p class="mb-1 text-muted"><?= htmlspecialchars($t['descripcion']) ?></p>
                        <div class="small"><b>Categoría:</b> <?= htmlspecialchars($t['categoria_nombre']) ?></div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a class="btn btn-outline-dark btn-sm" href="<?= BASE_URL ?>/?c=tareas&a=ver&id=<?= (int)$t['id'] ?>">
                            <i class="bi bi-search"></i>
                        </a>

                        <a class="btn btn-outline-dark btn-sm" href="<?= BASE_URL ?>/?c=tareas&a=editar&id=<?= (int)$t['id'] ?>">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button"
                            class="btn btn-outline-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEliminar<?= (int)$t['id'] ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
            <!-- Modal eliminar -->
            <div class="modal fade" id="modalEliminar<?= (int)$t['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmar eliminación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            ¿Seguro que quieres eliminar la tarea:<br>
                            <b><?= htmlspecialchars($t['titulo']) ?></b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancelar</button>
                            <a class="btn btn-danger"
                                href="<?= BASE_URL ?>/?c=tareas&a=eliminar&id=<?= (int)$t['id'] ?>">
                                Eliminar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php endforeach; ?>
</div>
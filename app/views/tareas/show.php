<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between">
        <span><b><?= htmlspecialchars($tarea['titulo']) ?></b></span>
        <span><?= htmlspecialchars($tarea['fecha']) ?> <?= htmlspecialchars($tarea['hora']) ?></span>
      </div>

      <div class="card-body">
        <p><b>Descripción:</b> <?= nl2br(htmlspecialchars($tarea['descripcion'])) ?></p>
        <p><b>Lugar:</b> <?= htmlspecialchars($tarea['lugar']) ?></p>
        <p><b>Prioridad:</b> <?= (int)$tarea['prioridad'] ?></p>
        <p><b>Categoría:</b> <?= htmlspecialchars($tarea['categoria_nombre']) ?></p>

        <img style="max-width:120px"
             src="<?= BASE_URL ?>/images/categorias/<?= htmlspecialchars($tarea['categoria_imagen']) ?>"
             alt="cat">

        <?php if (!empty($tarea['imagen'])): ?>
          <div class="mt-3">
            <div class="small text-muted">Imagen de la tarea:</div>
            <img src="<?= BASE_URL ?>/images/tareas/<?= htmlspecialchars($tarea['imagen']) ?>"
                 class="img-fluid rounded border"
                 style="max-height:260px; object-fit:cover;"
                 alt="img tarea">
          </div>
        <?php endif; ?>

        <div class="mt-3">
          <a class="btn btn-outline-dark" href="<?= BASE_URL ?>/?c=tareas&a=hoy">Volver</a>
        </div>
      </div>
    </div>
  </div>
</div>

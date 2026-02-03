<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Buscar tareas</h4>
  <a class="btn btn-outline-dark" href="<?= BASE_URL ?>/?c=tareas&a=hoy">
    <i class="bi bi-arrow-left"></i> Volver
  </a>
</div>

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <form method="get" class="row g-2 align-items-center">
      <input type="hidden" name="c" value="tareas">
      <input type="hidden" name="a" value="buscar">

      <div class="col-md-9">
        <input class="form-control" name="q" placeholder="Buscar por título..."
               value="<?= htmlspecialchars($q) ?>">
      </div>

      <div class="col-md-3 d-grid">
        <button class="btn btn-dark">
          <i class="bi bi-search"></i> Buscar
        </button>
      </div>
    </form>
    <div class="text-muted small mt-2">
      Escribe parte del título y pulsa Buscar.
    </div>
  </div>
</div>

<?php if ($q === ''): ?>
  <div class="alert alert-warning">
    Introduce un texto para buscar.
  </div>
<?php else: ?>

  <?php if (empty($tareas)): ?>
    <div class="alert alert-danger">
      No hay resultados para: <b><?= htmlspecialchars($q) ?></b>
    </div>
  <?php else: ?>
    <div class="alert alert-success">
      Resultados para: <b><?= htmlspecialchars($q) ?></b> (<?= count($tareas) ?>)
    </div>

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
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

<?php endif; ?>

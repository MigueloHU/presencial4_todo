<div class="row justify-content-center">
  <div class="col-md-7">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="mb-3"><?= $modo === 'crear' ? 'Añadir tarea' : 'Editar tarea' ?></h5>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="row g-2">
            <div class="col-md-6">
              <label class="form-label">Fecha</label>
              <input type="date" name="fecha" class="form-control" required value="<?= $tarea['fecha'] ?? '' ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label">Hora</label>
              <input type="time" name="hora" class="form-control" required value="<?= $tarea['hora'] ?? '' ?>">
            </div>

            <div class="col-12">
              <label class="form-label">Título</label>
              <input name="titulo" class="form-control" maxlength="25" required value="<?= $tarea['titulo'] ?? '' ?>">
            </div>

            <div class="col-12">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" class="form-control" rows="3" required><?= $tarea['descripcion'] ?? '' ?></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">Lugar</label>
              <input name="lugar" class="form-control" maxlength="25" required value="<?= $tarea['lugar'] ?? '' ?>">
            </div>

            <div class="col-md-3">
              <label class="form-label">Prioridad</label>
              <select name="prioridad" class="form-select">
                <?php for($i=1;$i<=3;$i++): ?>
                  <option value="<?= $i ?>"><?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label class="form-label">Categoría</label>
              <select name="cat_id" class="form-select" required>
                <option value="">-- elegir --</option>
                <?php foreach ($categorias as $c): ?>
                  <option value="<?= (int)$c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-12">
              <label class="form-label">Imagen tarea (texto, 2.6 será subida)</label>
              <input name="imagen" class="form-control" value="<?= $tarea['imagen'] ?? '' ?>">
            </div>
          </div>

          <div class="d-flex gap-2 mt-3">
            <button class="btn btn-dark">Guardar</button>
            <a class="btn btn-outline-dark" href="<?= BASE_URL ?>/?c=tareas&a=hoy">Volver</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

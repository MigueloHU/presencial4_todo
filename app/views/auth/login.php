<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm">
      <div class="card-body">
        <h5 class="card-title mb-3">Login</h5>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input class="form-control" name="usuario" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="clave" required>
          </div>
          <button class="btn btn-dark w-100">Entrar</button>
        </form>

        <div class="text-muted mt-3 small">
          (rápido) Usuario: <b>admin</b> · Clave: <b>1234</b>
        </div>
      </div>
    </div>
  </div>
</div>

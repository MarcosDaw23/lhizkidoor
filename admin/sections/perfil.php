<?php

if (!isset($_SESSION['user'])) {
    header("Location: /lhizkidoor-juan/auth/index.php?section=login");
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';


$usuarioSesion = $_SESSION['user'];
$id = intval($usuarioSesion['id']);


$db = new AccesoBD_Admin();
$usuario = $db->obtenerUsuarioPorId($id);
$centros = $db->obtenerCentros();
$sectores = $db->obtenerSectores();
$clases = $db->obtenerClases();


if (!$usuario) {
    echo "<div class='alert alert-danger text-center mt-5'>Usuario no encontrado.</div>";
    exit;
}
?>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Editar Usuario</h2>

  <form action="./controllers/actualizarUsuarios_controller.php" method="POST" class="bg-light p-4 rounded shadow-sm perfil-form">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Apellido</label>
        <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="mail" class="form-control" value="<?= htmlspecialchars($usuario['mail']) ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Rol</label>
        <select name="rol" class="form-select" required disabled>
          <option value="1" <?= $usuario['rol'] == 1 ? 'selected' : '' ?>>Administrador</option>
          <option value="2" <?= $usuario['rol'] == 2 ? 'selected' : '' ?>>Profesor</option>
          <option value="3" <?= $usuario['rol'] == 3 ? 'selected' : '' ?>>Usuario</option>
        </select>
      
        <input type="hidden" name="rol" value="<?= $usuario['rol'] ?>">
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Centro</label>
        <select name="centro" class="form-select">
          <?php foreach ($centros as $c): ?>
            <option value="<?= $c['id'] ?>" <?= $usuario['centro'] == $c['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($c['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Sector</label>
        <select name="sector" class="form-select">
          <?php foreach ($sectores as $s): ?>
            <option value="<?= $s['id'] ?>" <?= $usuario['sector'] == $s['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($s['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Clase</label>
        <select name="clase" class="form-select">
          <?php foreach ($clases as $cl): ?>
            <option value="<?= $cl['id'] ?>" <?= $usuario['clase'] == $cl['id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($cl['nombre']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="text-center mt-4">
      <button type="submit" class="btn btn-success me-2">Guardar cambios</button>
      <a href="index.php?section=home" class="btn btn-secondary">No guardar cambios</a>
    </div>
  </form>
</div>


<style>
  .perfil-form input:focus,
  .perfil-form select:focus {
    outline: none;
    box-shadow: none;
    border-color: #e2e8f0;
  }

  .perfil-form label {
    font-weight: 600;
    color: #1e293b;
  }

  .perfil-form .btn-success {
    background: #16a34a;
    border: none;
  }

  .perfil-form .btn-success:hover {
    background: #15803d;
  }

  .perfil-form .btn-secondary {
    background: #64748b;
    border: none;
  }

  .perfil-form .btn-secondary:hover {
    background: #475569;
  }
</style>

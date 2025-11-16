<?php

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
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

// Obtener la imagen de perfil o usar una por defecto
$imagenPerfil = !empty($usuario['imagen_perfil']) ? $usuario['imagen_perfil'] : null;
?>

<div class="perfil-container">
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      Perfil actualizado correctamente
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="perfil-header-simple">
    <h2 class="perfil-title">Mi Perfil</h2>
  </div>

  <form action="./controllers/actualizarUsuarios_controller.php" method="POST" enctype="multipart/form-data" class="perfil-form-simple">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <input type="file" name="imagen_perfil" id="imagenPerfilInput" accept="image/*" style="display: none;">

    <div class="perfil-foto-section">
      <label class="perfil-label-simple">Foto de Perfil</label>
      <div class="perfil-avatar-wrapper-center">
        <div class="perfil-avatar-simple" id="avatarPreview">
          <?php if ($imagenPerfil): ?>
            <img src="<?= htmlspecialchars($imagenPerfil) ?>" alt="Avatar" class="perfil-avatar-img-simple">
          <?php else: ?>
            <span class="perfil-avatar-inicial"><?= strtoupper(substr($usuario['nombre'], 0, 1)) ?></span>
          <?php endif; ?>
        </div>
        <label for="imagenPerfilInput" class="perfil-icon-cambiar">
          <i class="bi bi-camera-fill"></i>
        </label>
      </div>
    </div>

    <hr class="perfil-divider">

    <div class="perfil-grupo">
      <h3 class="perfil-subtitulo">Información Personal</h3>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="perfil-label-simple">Nombre</label>
          <input type="text" name="nombre" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple">Apellido</label>
          <input type="text" name="apellido" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple">Email</label>
          <input type="email" name="mail" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['mail']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple">Rol</label>
          <select name="rol" class="perfil-input-simple" disabled>
            <option value="1" <?= $usuario['rol'] == 1 ? 'selected' : '' ?>>Administrador</option>
            <option value="2" <?= $usuario['rol'] == 2 ? 'selected' : '' ?>>Profesor</option>
            <option value="3" <?= $usuario['rol'] == 3 ? 'selected' : '' ?>>Usuario</option>
          </select>
          <input type="hidden" name="rol" value="<?= $usuario['rol'] ?>">
        </div>
      </div>
    </div>

    <hr class="perfil-divider">

    <div class="perfil-grupo">
      <h3 class="perfil-subtitulo">Información Académica</h3>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="perfil-label-simple">Centro</label>
          <select name="centro" class="perfil-input-simple">
            <?php foreach ($centros as $c): ?>
              <option value="<?= $c['id'] ?>" <?= $usuario['centro'] == $c['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="perfil-label-simple">Sector</label>
          <select name="sector" class="perfil-input-simple">
            <?php foreach ($sectores as $s): ?>
              <option value="<?= $s['id'] ?>" <?= $usuario['sector'] == $s['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="perfil-label-simple">Clase</label>
          <select name="clase" class="perfil-input-simple">
            <?php foreach ($clases as $cl): ?>
              <option value="<?= $cl['id'] ?>" <?= $usuario['clase'] == $cl['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cl['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
    </div>

    <div class="perfil-botones">
      <button type="submit" class="perfil-btn-guardar">
        Guardar Cambios
      </button>
      <a href="index.php?section=home" class="perfil-btn-cancelar">
        Cancelar
      </a>
    </div>
  </form>
</div>

<script>
document.getElementById('imagenPerfilInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const preview = document.getElementById('avatarPreview');
      preview.innerHTML = '<img src="' + e.target.result + '" alt="Avatar" class="perfil-avatar-img-simple">';
    }
    reader.readAsDataURL(file);
  }
});
</script>
  </body>
</html>

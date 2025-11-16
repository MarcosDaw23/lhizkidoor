<?php

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';
require_once __DIR__ . '/../../core/Helpers.php';

$usuarioSesion = $_SESSION['user'];
$id = intval($usuarioSesion['id']);

$db = new AccesoBD_Usuario();
// Necesitaremos métodos para obtener datos del usuario
// Obtener datos completos del usuario desde la base de datos
$conn = (new AccesoBD())->conexion;
$sql = "SELECT nombre, apellido, mail FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$datosUsuario = $result->fetch_assoc();
$stmt->close();
mysqli_close($conn);

$usuario = [
    'id' => $id,
    'nombre' => $datosUsuario['nombre'] ?? $usuarioSesion['nombre'],
    'apellido' => $datosUsuario['apellido'] ?? '',
    'mail' => $datosUsuario['mail'] ?? '',
    'rol' => $usuarioSesion['rol'],
    'centro' => $usuarioSesion['centro'],
    'sector' => $usuarioSesion['sector'],
    'clase' => $usuarioSesion['clase'],
    'puntuacion' => $usuarioSesion['puntuacion']
];

// Obtener listas para selects (necesitarás implementar estos métodos)
$centros = $db->obtenerCentros();
$sectores = $db->obtenerSectores();
$clases = $db->obtenerClases();

// Obtener la imagen de perfil o usar una por defecto
$imagenPerfil = null; // Por ahora null, implementar después
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">

<div class="perfil-container">
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      <?= t('perfil_actualizado') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Mensajes de error -->
  <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-circle-fill me-2"></i>
      <?php 
        switch($_GET['error']) {
          case 'password_mismatch':
            echo t('password_no_coinciden');
            break;
          case 'password_short':
            echo t('password_muy_corta');
            break;
          case 'unauthorized':
            echo t('sin_permiso');
            if (isset($_GET['sid']) && isset($_GET['pid'])) {
                echo ' (Session ID: ' . htmlspecialchars($_GET['sid']) . ', Posted ID: ' . htmlspecialchars($_GET['pid']) . ')';
            }
            break;
          case 'no_session':
            echo t('sesion_expirada');
            break;
          default:
            echo t('error_actualizar');
        }
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <div class="perfil-header-simple">
    <h2 class="perfil-title"><?= t('mi_perfil_titulo') ?></h2>
  </div>

  <form action="./controllers/actualizarPerfil_controller.php" method="POST" enctype="multipart/form-data" class="perfil-form-simple">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <input type="file" name="imagen_perfil" id="imagenPerfilInput" accept="image/*" style="display: none;">

    <div class="perfil-foto-section">
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
      <h3 class="perfil-subtitulo"><?= t('informacion_personal') ?></h3>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="perfil-label-simple"><?= t('nombre') ?></label>
          <input type="text" name="nombre" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple"><?= t('apellidos') ?></label>
          <input type="text" name="apellido" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
        </div>
        <div class="col-12">
          <label class="perfil-label-simple"><?= t('email') ?></label>
          <input type="email" name="mail" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['mail']) ?>" required>
        </div>
        <div class="col-12">
          <label class="perfil-label-simple"><?= t('idioma') ?></label>
          <select name="idioma" class="perfil-input-simple" required>
            <option value="español" <?= ($_SESSION['user']['idioma'] ?? 'español') == 'español' ? 'selected' : '' ?>><?= t('español') ?></option>
            <option value="euskera" <?= ($_SESSION['user']['idioma'] ?? 'español') == 'euskera' ? 'selected' : '' ?>><?= t('euskera') ?></option>
          </select>
        </div>
      </div>
    </div>

    <hr class="perfil-divider">

    <!-- Cambiar Contraseña -->
    <div class="perfil-grupo">
      
      <div class="row g-3">
        <div class="col-md-6">
          <label class="perfil-label-simple"><?= t('nueva_password') ?></label>
          <input type="password" name="nueva_password" class="perfil-input-simple" minlength="8" placeholder="<?= t('minimo_caracteres') ?>">
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple"><?= t('confirmar_password') ?></label>
          <input type="password" name="confirmar_password" class="perfil-input-simple" minlength="8" placeholder="<?= t('repite_password') ?>">
        </div>
      </div>
    </div>

    <hr class="perfil-divider">

    <div class="perfil-grupo">
      <h3 class="perfil-subtitulo"><?= t('informacion_academica') ?></h3>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="perfil-label-simple"><?= t('centro') ?></label>
          <select name="centro" class="perfil-input-simple">
            <?php foreach ($centros as $c): ?>
              <option value="<?= $c['id'] ?>" <?= $usuario['centro'] == $c['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($c['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="perfil-label-simple"><?= t('sector') ?></label>
          <select name="sector" class="perfil-input-simple">
            <?php foreach ($sectores as $s): ?>
              <option value="<?= $s['id'] ?>" <?= $usuario['sector'] == $s['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="perfil-label-simple"><?= t('clase') ?></label>
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
        <i class="bi bi-check-circle-fill"></i>
        <?= t('guardar_cambios') ?>
      </button>
      <a href="index.php?section=home" class="perfil-btn-cancelar">
        <i class="bi bi-x-circle-fill"></i>
        <?= t('cancelar') ?>
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


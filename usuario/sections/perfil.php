<?php

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';

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

<style>
    .perfil-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .perfil-header-simple {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        text-align: center;
    }

    .perfil-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .perfil-form-simple {
        background: white;
        padding: 35px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .perfil-foto-section {
        margin-bottom: 30px;
    }

    .perfil-label-simple {
        display: block;
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
        margin-bottom: 10px;
    }

    .perfil-avatar-wrapper-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        position: relative;
    }

    .perfil-avatar-simple {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
        color: white;
        overflow: hidden;
        position: relative;
    }

    .perfil-avatar-img-simple {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .perfil-avatar-inicial {
        font-size: 3rem;
        font-weight: 700;
        color: white;
    }

    .perfil-icon-cambiar {
        position: absolute;
        bottom: 0;
        right: calc(50% - 60px);
        background: #667eea;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .perfil-icon-cambiar:hover {
        background: #5568d3;
        transform: scale(1.1);
    }

    .perfil-divider {
        margin: 30px 0;
        border: none;
        border-top: 1px solid #e2e8f0;
    }

    .perfil-grupo {
        margin-bottom: 30px;
    }

    .perfil-subtitulo {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 20px;
    }

    .perfil-input-simple {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 1rem;
        color: #2d3748;
        transition: all 0.2s ease;
        background: white;
    }

    .perfil-input-simple:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .perfil-input-simple:disabled {
        background: #f7fafc;
        cursor: not-allowed;
    }

    .perfil-botones {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }

    .perfil-btn-guardar {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .perfil-btn-guardar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
    }

    .perfil-btn-cancelar {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: white;
        color: #4a5568;
        border: 2px solid #e2e8f0;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .perfil-btn-cancelar:hover {
        border-color: #cbd5e0;
        background: #f7fafc;
        color: #4a5568;
    }

    @media (max-width: 768px) {
        .perfil-container {
            padding: 20px 15px;
        }

        .perfil-form-simple {
            padding: 25px;
        }

        .perfil-botones {
            flex-direction: column;
        }

        .perfil-btn-guardar,
        .perfil-btn-cancelar {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="perfil-container">
  <!-- Mensaje de éxito -->
  <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="bi bi-check-circle-fill me-2"></i>
      Perfil actualizado correctamente
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
            echo 'Las contraseñas no coinciden';
            break;
          case 'password_short':
            echo 'La contraseña debe tener al menos 8 caracteres';
            break;
          case 'unauthorized':
            echo 'No tienes permiso para realizar esta acción';
            if (isset($_GET['sid']) && isset($_GET['pid'])) {
                echo ' (Session ID: ' . htmlspecialchars($_GET['sid']) . ', Posted ID: ' . htmlspecialchars($_GET['pid']) . ')';
            }
            break;
          case 'no_session':
            echo 'Tu sesión ha expirado. Por favor, inicia sesión nuevamente.';
            break;
          default:
            echo 'Error al actualizar el perfil';
        }
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <!-- Header simple del perfil -->
  <div class="perfil-header-simple">
    <h2 class="perfil-title">Mi Perfil</h2>
  </div>

  <!-- Formulario simple -->
  <form action="./controllers/actualizarPerfil_controller.php" method="POST" enctype="multipart/form-data" class="perfil-form-simple">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <input type="file" name="imagen_perfil" id="imagenPerfilInput" accept="image/*" style="display: none;">

    <!-- Foto de perfil -->
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

    <!-- Información Personal -->
    <div class="perfil-grupo">
      <h3 class="perfil-subtitulo">Información Personal</h3>
      <div class="row g-3">
        <div class="col-md-6">
          <label class="perfil-label-simple">Nombre</label>
          <input type="text" name="nombre" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple">Apellidos</label>
          <input type="text" name="apellido" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['apellido']) ?>" required>
        </div>
        <div class="col-12">
          <label class="perfil-label-simple">Email</label>
          <input type="email" name="mail" class="perfil-input-simple" value="<?= htmlspecialchars($usuario['mail']) ?>" required>
        </div>
      </div>
    </div>

    <hr class="perfil-divider">

    <!-- Cambiar Contraseña -->
    <div class="perfil-grupo">
      
      <div class="row g-3">
        <div class="col-md-6">
          <label class="perfil-label-simple">Nueva Contraseña</label>
          <input type="password" name="nueva_password" class="perfil-input-simple" minlength="8" placeholder="Mínimo 8 caracteres">
        </div>
        <div class="col-md-6">
          <label class="perfil-label-simple">Confirmar Contraseña</label>
          <input type="password" name="confirmar_password" class="perfil-input-simple" minlength="8" placeholder="Repite la contraseña">
        </div>
      </div>
    </div>

    <hr class="perfil-divider">

    <!-- Información Académica -->
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

    <!-- Botones -->
    <div class="perfil-botones">
      <button type="submit" class="perfil-btn-guardar">
        <i class="bi bi-check-circle-fill"></i>
        Guardar Cambios
      </button>
      <a href="index.php?section=home" class="perfil-btn-cancelar">
        <i class="bi bi-x-circle-fill"></i>
        Cancelar
      </a>
    </div>
  </form>
</div>

<script>
// Preview de imagen de perfil
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


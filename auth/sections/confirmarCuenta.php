<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$mensaje = '';
$tipo = '';
$mostrarBoton = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $bd = new AccesoBD_Auth();

    if ($bd->confirmarUsuarioPorToken($token)) {
        $mensaje = "Tu cuenta ha sido confirmada correctamente";
        $tipo = "success";
        $mostrarBoton = true;
    } else {
        $mensaje = "El enlace no vale o ya fue utilizado";
        $tipo = "danger";
    }
} else {
    $mensaje = "No se token";
    $tipo = "warning";
}
?>

<section class="vh-100 d-flex justify-content-center align-items-center bg-light">
  <div class="card shadow-lg text-center p-5" style="max-width: 600px;">
    <h2 class="mb-4">Confirmación de cuenta</h2>

    <div class="alert alert-<?php echo $tipo; ?> text-center" role="alert">
      <?php echo htmlspecialchars($mensaje); ?>
    </div>

    <?php if ($mostrarBoton): ?>
      <a href="index.php?section=login" class="btn btn-success btn-lg mt-3">
        Ir al login
      </a>
    <?php else: ?>
      <a href="index.php?section=registro" class="btn btn-secondary btn-lg mt-3">
        Volver al registro
      </a>
    <?php endif; ?>
  </div>
</section>

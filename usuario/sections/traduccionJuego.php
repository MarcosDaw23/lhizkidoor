<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$bd = new AccesoBD_Usuario();

// 🔹 Usar la variable correcta de sesión
$usuarioId = $_SESSION['user']['id'] ?? 0;

if (!$usuarioId) {
    header("Location: ../index.php?section=login");
    exit;
}

$palabra = $bd->obtenerPalabraTraduccionPorUsuario($usuarioId);

if (!$palabra) {
    echo "<div class='alert alert-warning text-center mt-5'>
            No hay palabras disponibles para tu rama.
          </div>";
    exit;
}
?>

<section class="vh-100" style="background-color: #f8f9fa;">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">
        <div class="card shadow-lg border-0">
          <div class="card-body text-center p-5">

            <h2 class="fw-bold mb-4 text-primary">Traducción Rápida</h2>
            <p class="text-muted">Traduce la siguiente palabra del euskera al castellano:</p>

            <div class="my-4">
              <h1 class="display-4 fw-bold text-success" id="palabra-eusk"><?= htmlspecialchars($palabra['eusk']); ?></h1>
            </div>

            <form id="formTraduccion" method="POST" action="./controllers/traduccion_controller.php">
              <input type="hidden" name="id_palabra" value="<?= $palabra['id']; ?>">

              <div class="mb-4">
                <input type="text" name="respuesta" class="form-control form-control-lg text-center"
                       placeholder="Escribe la traducción en castellano" required autocomplete="off">
              </div>

              <button type="submit" class="btn btn-primary btn-lg px-5">Comprobar</button>
            </form>

            <hr class="my-5">

            <p class="text-muted small">
              <i class="bi bi-lightbulb"></i> Pista: <?= htmlspecialchars($palabra['definicion']); ?>
            </p>

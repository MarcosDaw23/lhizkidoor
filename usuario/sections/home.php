<?php
require_once __DIR__ . '/../../core/config.php';

// ✅ Usamos el valor de sesión sin tocar la base de datos
$yaJugo = $_SESSION['yaJugo'] ?? false;
?>

<div class="text-center mt-5">
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user']['nombre']) ?></h1>

  <?php if (!$yaJugo): ?>
    <p class="mt-3">Aun no has jugado esta semana</p>
    <a href="./controllers/PartidaSemanal_controller.php?action=jugar" class="btn btn-primary btn-lg">
      <i class="bi bi-play-fill"></i> Jugar partida semanal
    </a>
  <?php else: ?>
    <p class="mt-3">Ya jugaste esta semana</p>
    <a href="./controllers/PartidaSemanal_controller.php?action=repasar" class="btn btn-secondary btn-lg">
      <i class="bi bi-arrow-repeat"></i> Repasar
    </a>
  <?php endif; ?>
</div>


<br>
<br>
<a href="<?= Config::$LOGOUT ?>" class="btn btn-danger">
Cerrar sesión
</a>

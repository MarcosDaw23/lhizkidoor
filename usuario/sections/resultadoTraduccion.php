<?php
$datos = $_SESSION['resultado_traduccion'] ?? null;

if (!$datos) {
    header("Location: ../index.php?section=traduccionJuego");
    exit;
}
?>

<section class="vh-100" style="background-color: #f4f4f4;">
  <div class="container py-5">
    <div class="card text-center shadow-lg">
      <div class="card-body p-5">
        <h2 class="mb-4"><?= $datos['resultado']; ?></h2>
        <p><strong>Tu respuesta:</strong> <?= htmlspecialchars($datos['tu_respuesta']); ?></p>
        <p><strong>Respuesta correcta:</strong> <?= htmlspecialchars($datos['correcta']); ?></p>
        <h3 class="mt-4 text-success">Puntuación obtenida: <?= $datos['puntuacion']; ?> puntos</h3>

        <a href="./index.php?section=traduccionJuego" class="btn btn-primary mt-4">Jugar otra vez</a>
        <a href="./index.php?section=juegos" class="btn btn-primary mt-4">Volver</a>
      </div>
    </div>
  </div>
</section>

<?php
$resultados = $_SESSION['resultados'] ?? [];
$puntuacion = $_SESSION['puntuacion'] ?? 0;
$totalPreguntas = count($resultados);
$aciertos = 0;

if (empty($resultados)) {
    echo "<div class='text-center mt-5'>
            <h3>No hay resultados para mostrar.</h3>
            <a href='./index.php?section=juegos' class='btn btn-primary mt-3'>Volver</a>
          </div>";
    exit;
}

foreach ($resultados as $r) {
    if ($r['respuesta'] == $r['correcta']) {
        $aciertos++;
    }
}
?>

<div class="container mt-5">
  <h2 class="text-center mb-4 fw-bold">Resultados del juego</h2>

  <?php foreach ($resultados as $i => $r): ?>
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h5 class="fw-bold">Pregunta <?= $i + 1 ?></h5>
        <p><strong>Definición:</strong> <?= htmlspecialchars($r['definicion']) ?></p>

        <p>
          <strong>Tu respuesta:</strong>
          <span class="<?= $r['respuesta'] == $r['correcta'] ? 'text-success' : 'text-danger' ?>">
            <?= htmlspecialchars($r['opciones'][$r['respuesta']] ?? 'Sin respuesta') ?>
          </span>
        </p>

        <?php if ($r['respuesta'] != $r['correcta']): ?>
          <p><strong>Respuesta correcta:</strong>
            <span class="text-success"><?= htmlspecialchars($r['opciones'][$r['correcta']]) ?></span>
          </p>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>

  <div class="text-center mt-4">
    <h4>Aciertos: <?= $aciertos ?> / <?= $totalPreguntas ?></h4>
    <h5>Puntuación total: <?= $puntuacion ?> puntos</h5>
    <a href="./index.php?section=juegos" class="btn btn-primary mt-3">Volver a los modos de juego</a>
  </div>
</div>

<?php
// limpio las sessiones que luego peta, aun mas
unset($_SESSION['preguntas'], $_SESSION['indicePregunta'], $_SESSION['resultados'], $_SESSION['puntuacion'], $_SESSION['modo']);
?>

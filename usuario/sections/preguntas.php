<?php
$preguntas = $_SESSION['preguntas'] ?? [];
$indice = $_SESSION['indicePregunta'] ?? 0;
$total = count($preguntas);

if (empty($preguntas)) {
    echo "<div class='text-center mt-5'>
            <h3>No hay preguntas cargadas.</h3>
            <a href='./controllers/Preguntas_controller.php?action=start' class='btn btn-primary mt-3'>Iniciar juego</a>
          </div>";
    exit;
}

$pregunta = $preguntas[$indice];
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow p-4" style="max-width: 600px; width:100%;">
    <h4 class="text-center mb-4">Pregunta <?= $indice + 1 ?> / <?= $total ?></h4>

    <p class="lead text-center mb-4"><strong>Definición:</strong> <?= htmlspecialchars($pregunta['definicion']) ?></p>

    <form method="POST" action="./controllers/Preguntas_controller.php?action=responder">
      <?php
        $opciones = [
          1 => $pregunta['eusk1'],
          2 => $pregunta['eusk2'],
          3 => $pregunta['eusk3']
        ];
        asort($opciones);
        foreach ($opciones as $key => $value):
      ?>
        <div class="form-check text-start mb-2">
          <input class="form-check-input" type="radio" name="opcion" id="op<?= $key ?>" value="<?= $key ?>" required>
          <label class="form-check-label" for="op<?= $key ?>">
            <?= htmlspecialchars($value) ?>
          </label>
        </div>
      <?php endforeach; ?>

      <?php if ($indice + 1 == $total): ?>
        <button type="submit" class="btn btn-success w-100 mt-3">Finalizar</button>
      <?php else: ?>
        <button type="submit" class="btn btn-primary w-100 mt-3">Siguiente</button>
      <?php endif; ?>
    </form>

    <p class="text-center text-muted mt-3">Puntuación actual: <?= $_SESSION['puntuacion'] ?? 0 ?> pts</p>
  </div>
</div>

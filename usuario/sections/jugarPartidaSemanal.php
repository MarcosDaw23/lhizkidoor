<?php
$palabra = $_SESSION['palabra'] ?? null;

if (!$palabra) {
    echo "<div class='alert alert-danger text-center'>No se encontró ninguna palabra.</div>";
    exit;
}
?>
<div class="container mt-5 text-center">
  <h2 class="mb-4">Partida semanal</h2>

  <div class="card mx-auto shadow" style="max-width: 600px;">
    <div class="card-body">
      <p class="lead"><strong>Definición:</strong> <?= htmlspecialchars($palabra['definicion']) ?></p>

      <form action="./controllers/PartidaSemanal_controller.php?action=verificar" method="POST">
        <input type="hidden" name="id" value="<?= $palabra['id'] ?>">

        <?php
          $opciones = [
              1 => $palabra['eusk1'],
              2 => $palabra['eusk2'],
              3 => $palabra['eusk3']
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

        <button type="submit" class="btn btn-success mt-3 w-100">
          Enviar respuesta
        </button>
      </form>
    </div>
  </div>
</div>

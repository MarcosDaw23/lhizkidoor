<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 2) {
  header("Location: ../../auth/index.php?section=login");
  exit;
}

$db = new AccesoBD_Profesor();
$clases = $db->obtenerTodasLasClases();
$sectores = $db->obtenerTodosLosSectores();
?>

<section class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-primary text-white text-center rounded-top-4">
      <h3 class="mb-0"><i class="bi bi-calendar-event"></i> Crear nuevo evento</h3>
    </div>

    <div class="card-body p-4">
      <form id="crearEventoForm" action="./controllers/CrearEvento_controller.php" method="POST">

        <!-- Nombre del evento -->
        <div class="mb-3">
          <label for="nombre" class="form-label fw-semibold">Nombre del evento</label>
          <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <!-- Número de preguntas -->
        <div class="mb-3">
          <label for="num_preguntas" class="form-label fw-semibold">Cantidad de preguntas</label>
          <input type="number" name="num_preguntas" id="num_preguntas" class="form-control" min="1" max="50" required>
        </div>

        <!-- Tipo de destino -->
        <div class="mb-4">
          <label class="form-label fw-semibold">Tipo de destinatarios</label>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipo_destino" id="destinoClases" value="clase" checked>
            <label class="form-check-label" for="destinoClases">Por clases</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="tipo_destino" id="destinoSectores" value="sector">
            <label class="form-check-label" for="destinoSectores">Por sectores</label>
          </div>
        </div>

        <!-- Selector de clases -->
        <div id="selectClases" class="mb-4">
          <label class="form-label fw-semibold">Seleccionar clases participantes</label>
          <select name="clases[]" class="form-select" multiple>
            <?php foreach ($clases as $clase): ?>
              <option value="<?= $clase['id'] ?>"><?= htmlspecialchars($clase['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="text-muted">Mantén Ctrl o Cmd para seleccionar varias.</small>
        </div>

        <!-- Selector de sectores (oculto al inicio) -->
        <div id="selectSectores" class="mb-4 d-none">
          <label class="form-label fw-semibold">Seleccionar sectores participantes</label>
          <select name="sectores[]" class="form-select" multiple>
            <?php foreach ($sectores as $sector): ?>
              <option value="<?= $sector['id'] ?>"><?= htmlspecialchars($sector['nombre']) ?></option>
            <?php endforeach; ?>
          </select>
          <small class="text-muted">Mantén Ctrl o Cmd para seleccionar varios.</small>
        </div>

        <!-- Botón de confirmación -->
        <div class="text-center mt-4">
          <button type="button" class="btn btn-success btn-lg px-5" onclick="confirmarEvento()">
            <i class="bi bi-check-circle"></i> Crear evento
          </button>
        </div>

      </form>
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const radioClases = document.getElementById("destinoClases");
  const radioSectores = document.getElementById("destinoSectores");
  const selectClases = document.getElementById("selectClases");
  const selectSectores = document.getElementById("selectSectores");

  function actualizarSelector() {
    if (radioClases.checked) {
      selectClases.classList.remove("d-none");
      selectSectores.classList.add("d-none");
    } else {
      selectClases.classList.add("d-none");
      selectSectores.classList.remove("d-none");
    }
  }

  radioClases.addEventListener("change", actualizarSelector);
  radioSectores.addEventListener("change", actualizarSelector);
  actualizarSelector();
});

function confirmarEvento() {
  if (confirm("¿Seguro que deseas crear este evento y enviar correos a los participantes?")) {
    document.getElementById("crearEventoForm").submit();
  }
}
</script>

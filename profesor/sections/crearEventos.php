<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 2) {
  header("Location: ../../auth/index.php?section=login");
  exit;
}

$db = new AccesoBD_Profesor();
$clases = $db->obtenerClases();
$sectores = $db->obtenerSectores();
?>

<link rel="stylesheet" href="css/profesorfinal.css">


<div class="crear-evento-container">
  <div class="evento-header">
    <div class="evento-title">
      <i class="bi bi-calendar-event-fill"></i>
      <h1>Crear Nuevo Evento</h1>
    </div>
    <p class="evento-subtitle">Configura los detalles del evento para tus estudiantes</p>
  </div>

  <!-- Formulario -->
  <div class="evento-form-card">
    <form id="crearEventoForm" action="./controllers/CrearEvento_controller.php" method="POST">
      
      <!-- Nombre del evento -->
      <div class="form-group">
        <label for="nombre">
          <i class="bi bi-pencil-fill"></i>
          Nombre del evento
        </label>
        <input 
          type="text" 
          name="nombre" 
          id="nombre" 
          class="form-control-modern" 
          placeholder="Ej: Quiz de Euskera - Nivel Básico"
          required>
      </div>

      <!-- Número de preguntas -->
      <div class="form-group">
        <label for="num_preguntas">
          <i class="bi bi-question-circle-fill"></i>
          Cantidad de preguntas
        </label>
        <input 
          type="number" 
          name="num_preguntas" 
          id="num_preguntas" 
          class="form-control-modern" 
          min="1" 
          max="50" 
          placeholder="Número de preguntas (1-50)"
          required>
        <div class="form-hint">
          <i class="bi bi-info-circle"></i>
          <span>Mínimo 1, máximo 50 preguntas</span>
        </div>
      </div>

      <!-- Selector de clases -->
      <div id="selectClases" class="form-group">
        <label>
          <i class="bi bi-people-fill"></i>
          Seleccionar clases participantes
          <span class="selection-counter" id="clasesCounter">
            <i class="bi bi-check2-circle"></i>
            <span>0 seleccionadas</span>
          </span>
        </label>
        <div class="clases-grid">
          <?php foreach ($clases as $clase): ?>
            <div class="clase-checkbox-item">
              <input 
                type="checkbox" 
                name="clases[]" 
                value="<?= $clase['id'] ?>" 
                id="clase_<?= $clase['id'] ?>"
                onchange="updateCounter()">
              <label for="clase_<?= $clase['id'] ?>" class="clase-checkbox-label">
                <div class="checkbox-custom">
                  <i class="bi bi-check-lg"></i>
                </div>
                <span class="clase-name"><?= htmlspecialchars($clase['nombre']) ?></span>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="form-hint">
          <i class="bi bi-info-circle"></i>
          <span>Selecciona una o más clases que participarán en el evento</span>
        </div>
      </div>

      <!-- Selector de sectores (oculto al inicio) -->
      <div id="selectSectores" class="form-group d-none">
        <label>
          <i class="bi bi-mortarboard-fill"></i>
          Seleccionar sectores participantes
          <span class="selection-counter" id="sectoresCounter">
            <i class="bi bi-check2-circle"></i>
            <span>0 seleccionados</span>
          </span>
        </label>
        <div class="clases-grid">
          <?php foreach ($sectores as $sector): ?>
            <div class="clase-checkbox-item">
              <input 
                type="checkbox" 
                name="sectores[]" 
                value="<?= $sector['id'] ?>" 
                id="sector_<?= $sector['id'] ?>"
                onchange="updateCounter()">
              <label for="sector_<?= $sector['id'] ?>" class="clase-checkbox-label">
                <div class="checkbox-custom">
                  <i class="bi bi-check-lg"></i>
                </div>
                <span class="clase-name"><?= htmlspecialchars($sector['nombre']) ?></span>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="form-hint">
          <i class="bi bi-info-circle"></i>
          <span>Selecciona uno o más sectores que participarán en el evento</span>
        </div>
      </div>

      <!-- Botón de confirmación -->
      <div class="submit-container">
        <button type="button" class="btn-crear-evento" onclick="confirmarEvento()">
          <i class="bi bi-check-circle-fill"></i>
          Crear evento
        </button>
      </div>

    </form>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const radioClases = document.getElementById("destinoClases");
  const radioSectores = document.getElementById("destinoSectores");
  const selectClases = document.getElementById("selectClases");
  const selectSectores = document.getElementById("selectSectores");

  function actualizarSelector() {
    if (radioClases && radioClases.checked) {
      selectClases.classList.remove("d-none");
      selectSectores.classList.add("d-none");
    } else if (radioSectores && radioSectores.checked) {
      selectClases.classList.add("d-none");
      selectSectores.classList.remove("d-none");
    }
  }

  if (radioClases && radioSectores) {
    radioClases.addEventListener("change", actualizarSelector);
    radioSectores.addEventListener("change", actualizarSelector);
    actualizarSelector();
  }

  // Inicializar contador
  updateCounter();
});

function updateCounter() {
  // Contar clases seleccionadas
  const clasesChecked = document.querySelectorAll('input[name="clases[]"]:checked').length;
  const clasesCounter = document.getElementById('clasesCounter');
  const clasesCounterSpan = clasesCounter.querySelector('span');
  
  clasesCounterSpan.textContent = clasesChecked === 1 ? '1 seleccionada' : `${clasesChecked} seleccionadas`;
  
  if (clasesChecked > 0) {
    clasesCounter.classList.add('active');
  } else {
    clasesCounter.classList.remove('active');
  }

  // Contar sectores seleccionados
  const sectoresChecked = document.querySelectorAll('input[name="sectores[]"]:checked').length;
  const sectoresCounter = document.getElementById('sectoresCounter');
  const sectoresCounterSpan = sectoresCounter.querySelector('span');
  
  sectoresCounterSpan.textContent = sectoresChecked === 1 ? '1 seleccionado' : `${sectoresChecked} seleccionados`;
  
  if (sectoresChecked > 0) {
    sectoresCounter.classList.add('active');
  } else {
    sectoresCounter.classList.remove('active');
  }
}

function confirmarEvento() {
  // Validar que se haya seleccionado al menos una clase o sector
  const clasesChecked = document.querySelectorAll('input[name="clases[]"]:checked').length;
  const sectoresChecked = document.querySelectorAll('input[name="sectores[]"]:checked').length;
  
  if (clasesChecked === 0 && sectoresChecked === 0) {
    alert('Por favor, selecciona al menos una clase o sector para el evento.');
    return;
  }
  
  if (confirm("¿Seguro que deseas crear este evento y enviar correos a los participantes?")) {
    document.getElementById("crearEventoForm").submit();
  }
}
</script>

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

<style>
  .crear-evento-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 30px 20px;
  }

  .evento-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
  }

  .evento-title {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 8px;
  }

  .evento-title i {
    font-size: 2.5rem;
    color: #667eea;
  }

  .evento-title h1 {
    font-size: 2rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
  }

  .evento-subtitle {
    color: #718096;
    font-size: 1rem;
    margin: 0;
  }

  .evento-form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 35px;
  }

  .form-group {
    margin-bottom: 25px;
  }

  .form-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2d3748;
    font-size: 0.95rem;
    margin-bottom: 10px;
  }

  .form-group label i {
    color: #667eea;
    font-size: 1.1rem;
  }

  .form-control-modern,
  .form-select-modern {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 1rem;
    color: #2d3748;
    transition: all 0.2s ease;
    background: white;
  }

  .form-control-modern:focus,
  .form-select-modern:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  .form-select-modern {
    min-height: 150px;
    cursor: pointer;
  }

  .form-select-modern option {
    padding: 10px;
  }

  .form-select-modern option:checked {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
  }

  /* Selector de clases con checkboxes */
  .clases-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 12px;
    margin-top: 12px;
  }

  .clase-checkbox-item {
    position: relative;
  }

  .clase-checkbox-item input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .clase-checkbox-label {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: white;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 500;
    color: #2d3748;
  }

  .clase-checkbox-label:hover {
    border-color: #cbd5e0;
    background: #f7fafc;
  }

  .clase-checkbox-item input[type="checkbox"]:checked + .clase-checkbox-label {
    border-color: #667eea;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
  }

  .checkbox-custom {
    width: 22px;
    height: 22px;
    border: 2px solid #cbd5e0;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    flex-shrink: 0;
  }

  .clase-checkbox-item input[type="checkbox"]:checked + .clase-checkbox-label .checkbox-custom {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: #667eea;
  }

  .checkbox-custom i {
    color: white;
    font-size: 0.75rem;
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  .clase-checkbox-item input[type="checkbox"]:checked + .clase-checkbox-label .checkbox-custom i {
    opacity: 1;
  }

  .clase-name {
    flex: 1;
  }

  .selection-counter {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #edf2f7;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 0.875rem;
    color: #4a5568;
    font-weight: 600;
    margin-left: 10px;
  }

  .selection-counter.active {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
  }

  .form-hint {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 8px;
    font-size: 0.875rem;
    color: #718096;
  }

  .form-hint i {
    font-size: 1rem;
  }

  .submit-container {
    margin-top: 35px;
    text-align: center;
  }

  .btn-crear-evento {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 14px 40px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.05rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
  }

  .btn-crear-evento:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  }

  .btn-crear-evento:active {
    transform: translateY(0);
  }

  .btn-crear-evento i {
    font-size: 1.3rem;
  }

  .d-none {
    display: none !important;
  }

  /* Animación de entrada */
  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(10px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .evento-form-card {
    animation: fadeIn 0.4s ease;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .crear-evento-container {
      padding: 20px 15px;
    }

    .evento-header {
      padding: 20px;
    }

    .evento-title {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }

    .evento-title h1 {
      font-size: 1.5rem;
    }

    .evento-form-card {
      padding: 25px;
    }

    .btn-crear-evento {
      width: 100%;
      justify-content: center;
    }
  }
</style>

<div class="crear-evento-container">
  <!-- Header -->
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

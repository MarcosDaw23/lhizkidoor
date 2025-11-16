<?php
$datos = $_SESSION['resultado_traduccion'] ?? null;

if (!$datos) {
    header("Location: ../index.php?section=traduccionJuego");
    exit;
}

// Determinar si es correcto o incorrecto
$esCorrecto = (strtolower(trim($datos['tu_respuesta'])) === strtolower(trim($datos['correcta'])));
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">

<div class="resultado-container">
    <div class="resultado-card">
        <div class="resultado-icon <?= $esCorrecto ? 'correcto' : 'incorrecto' ?>">
            <i class="bi bi-<?= $esCorrecto ? 'check-circle-fill' : 'x-circle-fill' ?>"></i>
        </div>

        <div class="resultado-detalle">
            <div class="respuesta-item tu-respuesta">
                <div class="respuesta-label">
                    <i class="bi bi-pencil-fill"></i> Tu respuesta
                </div>
                <div class="respuesta-texto">
                    <?= htmlspecialchars($datos['tu_respuesta']); ?>
                </div>
            </div>

            <div class="respuesta-item respuesta-correcta">
                <div class="respuesta-label">
                    <i class="bi bi-check2-circle"></i> Respuesta correcta
                </div>
                <div class="respuesta-texto">
                    <?= htmlspecialchars($datos['correcta']); ?>
                </div>
            </div>
        </div>

        <div class="botones-container">
            <a href="./index.php?section=traduccionJuego" class="btn-resultado btn-primary-custom">
                <i class="bi bi-arrow-repeat"></i>
                <span>Jugar otra vez</span>
            </a>
            <a href="./index.php?section=juegos" class="btn-resultado btn-secondary-custom">
                <i class="bi bi-house-door-fill"></i>
                <span>Volver</span>
            </a>
      </div>
    </div>
  </div>

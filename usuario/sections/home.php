<?php
require_once __DIR__ . '/../../core/config.php';
require_once __DIR__ . '/../../core/Helpers.php';

$yaJugo = $_SESSION['yaJugo'] ?? false;
$nombreUsuario = $_SESSION['user']['nombre'] ?? 'Usuario';
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">


<div class="hero-section">
    <!-- Botón de configuración en esquina superior derecha -->
    <a href="./index.php?section=perfil" class="settings-icon-mobile" title="Configuración">
        <i class="bi bi-gear-fill"></i>
    </a>

    <div class="greeting-container">
        <h1 class="hero-greeting">
            <?= t('kaixo') ?>, <?= htmlspecialchars($nombreUsuario) ?>!
        </h1>
    </div>

  <?php if (!$yaJugo): ?>
        <div class="status-badge warning">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span><?= t('aun_no_jugado') ?></span>
        </div>

        <p class="hero-subtitle">
            <?= t('pon_prueba') ?><br>
            <?= t('demuestra') ?>
        </p>

        <a href="./controllers/PartidaSemanal_controller.php?action=jugar" class="play-button">
            <i class="bi bi-play-circle-fill"></i>
            <span><?= t('jugar_partida_semanal') ?></span>
    </a>
  <?php else: ?>
        <div class="status-badge success">
            <i class="bi bi-check-circle-fill"></i>
            <span><?= t('completaste_partida') ?></span>
        </div>

        <p class="hero-subtitle">
            <?= t('excelente_trabajo') ?><br>
            <?= t('puedes_repasar') ?>
        </p>

        <a href="./index.php?section=juegos" class="secondary-button">
            <i class="bi bi-arrow-repeat"></i>
            <span><?= t('repasar_preguntas') ?></span>
    </a>
  <?php endif; ?>
</div>

<!-- Estadísticas rápidas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-star-fill"></i>
        </div>
        <div class="stat-title"><?= t('tu_puntuacion') ?></div>
        <div class="stat-value"><?= $_SESSION['user']['puntuacion'] ?? 0 ?></div>
    </div>
</div>

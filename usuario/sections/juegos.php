<?php
require_once __DIR__ . '/../../core/Helpers.php';
$yaJugo = $_SESSION['yaJugo'] ?? false;
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">


<div class="games-container">
    <!-- Estado de la partida semanal -->
    <?php if (!$yaJugo): ?>
        <div class="status-card">
            <div class="status-card-content">
                <div class="status-icon available">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="status-message"><?= t('partida_disponible') ?></div>
                <p style="color: #666; font-size: 1.05rem; margin-bottom: 25px;"><?= t('completa_desafio') ?></p>
                <a href="./controllers/PartidaSemanal_controller.php?action=jugar" class="play-now-btn">
                    <i class="bi bi-play-fill"></i> <?= t('juega_ahora') ?>
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="status-card">
            <div class="status-card-content">
                <div class="status-icon played">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="status-message"><?= t('partida_completada') ?></div>
                <div class="countdown-container">
                    <p class="countdown-label"><?= t('proxima_partida') ?></p>
                    <div id="cronometro" class="countdown-display">
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text"><?= t('dias') ?></div>
                        </div>
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text"><?= t('horas') ?></div>
                        </div>
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text"><?= t('min') ?></div>
                        </div>
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text"><?= t('seg') ?></div>
                        </div>
                    </div>
                </div>
        </div>
      </div>
    <?php endif; ?>

    <!-- Grid de juegos -->
    <div class="games-grid">
        <!-- Práctica Libre -->
        <a href="./controllers/Preguntas_controller.php?action=start" class="game-card practica">
            <div class="game-icon-wrapper">
                <div class="game-icon">
                    💡
                </div>
            </div>
            <h3 class="game-title"><?= t('practica_libre') ?></h3>
            <p class="game-description">
                <?= t('desc_practica_libre') ?>
            </p>
            <span class="game-badge badge-popular">
                <i class="bi bi-fire"></i> <?= t('mas_popular') ?>
            </span>
        </a>

        <!-- Traducción -->
        <a href="./index.php?section=traduccionJuego" class="game-card traduccion">
            <div class="game-icon-wrapper">
                <div class="game-icon">
                    ✍️
                </div>
            </div>
            <h3 class="game-title"><?= t('traduccion_rapida') ?></h3>
            <p class="game-description">
                <?= t('desc_traduccion') ?>
            </p>
            <span class="game-badge badge-new">
                <i class="bi bi-stars"></i> <?= t('nuevo') ?>
            </span>
        </a>

        <!-- Ahorcado -->
        <a href="#" class="game-card ahorcado">
            <div class="game-icon-wrapper">
                <div class="game-icon">
                    🎯
                </div>
            </div>
            <h3 class="game-title"><?= t('ahorcado_tecnico') ?></h3>
            <p class="game-description">
                <?= t('desc_ahorcado') ?>
            </p>
            <span class="game-badge badge-soon">
                <i class="bi bi-clock"></i> <?= t('proximamente') ?>
            </span>
        </a>
  </div>
</div>

<?php if ($yaJugo): ?>
<script>
  function calcularProximoLunes() {
    const ahora = new Date();
    const proximoLunes = new Date(ahora);
    const dia = ahora.getDay();
    const diasParaLunes = (8 - dia) % 7;
    proximoLunes.setDate(ahora.getDate() + diasParaLunes);
    proximoLunes.setHours(1, 0, 0, 0);
    if (ahora > proximoLunes) proximoLunes.setDate(proximoLunes.getDate() + 7);
    return proximoLunes;
  }

  function iniciarCuentaRegresiva() {
    const destino = calcularProximoLunes();
    const intervalo = setInterval(() => {
      const ahora = new Date();
      const diff = destino - ahora;
      if (diff <= 0) {
        clearInterval(intervalo);
        location.reload(); 
        return;
      }

      const d = Math.floor(diff / (1000 * 60 * 60 * 24));
      const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const s = Math.floor((diff % (1000 * 60)) / 1000);
      
      const units = document.querySelectorAll('.countdown-number');
      if (units.length >= 4) {
        units[0].textContent = d;
        units[1].textContent = h;
        units[2].textContent = m;
        units[3].textContent = s;
      }
    }, 1000);
  }

  iniciarCuentaRegresiva();
</script>
<?php endif; ?>

<?php
$preguntas = $_SESSION['preguntas'] ?? [];
$indice = $_SESSION['indicePregunta'] ?? 0;
$total = count($preguntas);

if (empty($preguntas)) {
    echo "<div class='empty-state-game'>
            <div class='empty-glow'></div>
            <div class='empty-icon'>
                <i class='bi bi-question-circle'></i>
            </div>
            <h3>No hay preguntas cargadas</h3>
            <p>¡Comienza una nueva partida para poner a prueba tus conocimientos!</p>
            <a href='./controllers/Preguntas_controller.php?action=start' class='btn-start-game'>
                <i class='bi bi-play-circle-fill'></i>
                Iniciar juego
            </a>
          </div>";
    exit;
}

$pregunta = $preguntas[$indice];
$progreso = (($indice + 1) / $total) * 100;
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">

<div class="game-container">
    <div class="question-card">
        <div class="question-header">
            <div class="question-number">
                <i class="bi bi-question-circle-fill"></i>
                <span>Pregunta <?= $indice + 1 ?> de <?= $total ?></span>
            </div>
            
            <div class="progress-bar-container">
                <div class="progress-bar-fill" style="width: <?= $progreso ?>%"></div>
            </div>

        
        </div>

        <div class="definition-box">
            <div class="definition-label">
                <i class="bi bi-book"></i>
                <span>Definición</span>
            </div>
            <div class="definition-text">
                <?= htmlspecialchars($pregunta['definicion']) ?>
            </div>
        </div>

        <form method="POST" action="./controllers/Preguntas_controller.php?action=responder">
            <div class="options-container">
                <?php
                    $opciones = [
                        1 => $pregunta['eusk1'],
                        2 => $pregunta['eusk2'],
                        3 => $pregunta['eusk3']
                    ];
                    asort($opciones);
                    $letras = ['A', 'B', 'C'];
                    $index = 0;
                    foreach ($opciones as $key => $value):
                ?>
                    <label class="option-card" for="op<?= $key ?>">
                        <div class="option-letter"><?= $letras[$index] ?></div>
                        <input type="radio" name="opcion" id="op<?= $key ?>" value="<?= $key ?>" required>
                        <span class="option-label"><?= htmlspecialchars($value) ?></span>
                    </label>
                <?php 
                    $index++;
                    endforeach; 
                ?>
            </div>

            <?php if ($indice + 1 == $total): ?>
                <button type="submit" class="submit-button final">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>Finalizar Partida</span>
                </button>
            <?php else: ?>
                <button type="submit" class="submit-button">
                    <i class="bi bi-arrow-right-circle-fill"></i>
                    <span>Siguiente Pregunta</span>
                </button>
            <?php endif; ?>
        </form>

        <div class="score-display">
            <i class="bi bi-star-fill"></i>
            <span class="score-text">Puntuación actual: <?= $_SESSION['puntuacion'] ?? 0 ?> pts</span>
        </div>
    </div>
</div>

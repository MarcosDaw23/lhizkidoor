<?php
$resultados = $_SESSION['resultados'] ?? [];
$puntuacion = $_SESSION['puntuacion'] ?? 0;
$totalPreguntas = count($resultados);
$aciertos = 0;

if (empty($resultados)) {
    echo "<div class='empty-state-results'>
            <div class='particles'></div>
            <div class='empty-icon'>
                <i class='bi bi-clipboard-x'></i>
            </div>
            <h3>No hay resultados para mostrar</h3>
            <p>Juega una partida para ver tus resultados</p>
            <a href='./index.php?section=juegos' class='btn-back'>
                <i class='bi bi-arrow-left'></i> Volver a Juegos
            </a>
          </div>";
    exit;
}

foreach ($resultados as $r) {
    if ($r['respuesta'] == $r['correcta']) {
        $aciertos++;
    }
}

$porcentaje = ($aciertos / $totalPreguntas) * 100;
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">

<div class="results-container">
    <div class="results-hero">
        <div class="congrats-icon">
            <?php if ($porcentaje >= 70): ?>
                🎉
            <?php elseif ($porcentaje >= 50): ?>
                👍
            <?php else: ?>
                💪
            <?php endif; ?>
        </div>
        
        <h1 class="results-title">
            <?php if ($porcentaje >= 70): ?>
                ¡Excelente Trabajo!
            <?php elseif ($porcentaje >= 50): ?>
                ¡Buen Intento!
            <?php else: ?>
                ¡Sigue Practicando!
            <?php endif; ?>
        </h1>
        
        <p class="results-subtitle">Has completado la partida con éxito</p>

        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-value"><?= $aciertos ?>/<?= $totalPreguntas ?></div>
                <div class="stat-label">Respuestas Correctas</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?= number_format($porcentaje, 1) ?>%</div>
                <div class="stat-label">Precisión</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><?= $puntuacion ?></div>
                <div class="stat-label">Puntos Ganados</div>
            </div>
        </div>
    </div>

    <div class="questions-timeline">
        <div class="timeline-line"></div>
        
        <?php $numero = 1; foreach ($resultados as $r): 
            $esCorrecta = ($r['respuesta'] == $r['correcta']);
        ?>
            <div class="question-item">
                <div class="question-marker <?= $esCorrecta ? 'correct' : 'incorrect' ?>">
                    <?= $numero ?>
                </div>
                
                <div class="question-card <?= $esCorrecta ? 'correct' : 'incorrect' ?>">
                    <div class="question-header">
                        <span class="question-title">Pregunta <?= $numero ?></span>
                        <span class="result-badge <?= $esCorrecta ? 'correct' : 'incorrect' ?>">
                            <i class="bi bi-<?= $esCorrecta ? 'check-circle-fill' : 'x-circle-fill' ?>"></i>
                            <?= $esCorrecta ? 'Correcta' : 'Incorrecta' ?>
                        </span>
                    </div>
                    
                    <div class="question-text">
                        <?= htmlspecialchars($r['definicion']) ?>
                    </div>
                    
                    <div class="answers-grid">
                        <div class="answer-item your-answer">
                            <span class="answer-label">Tu respuesta:</span>
                            <span class="answer-value"><?= htmlspecialchars($r['respuesta']) ?></span>
                            <i class="bi bi-<?= $esCorrecta ? 'check-circle-fill' : 'x-circle-fill' ?> answer-icon <?= $esCorrecta ? 'correct' : 'incorrect' ?>"></i>
                        </div>
                        
                        <?php if (!$esCorrecta): ?>
                            <div class="answer-item correct-answer">
                                <span class="answer-label">Correcta:</span>
                                <span class="answer-value"><?= htmlspecialchars($r['correcta']) ?></span>
                                <i class="bi bi-check-circle-fill answer-icon correct"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php $numero++; endforeach; ?>
    </div>

    <div class="action-buttons">
        <a href="./index.php?section=juegos" class="btn btn-primary">
            <i class="bi bi-controller"></i>
            Jugar Otra Partida
        </a>
        <a href="./index.php" class="btn btn-secondary">
            <i class="bi bi-house-fill"></i>
            Volver al Inicio
        </a>
    </div>
</div>

<?php
// 🔹 Limpia resultados después de mostrarlos
unset($_SESSION['resultados']);
unset($_SESSION['indicePregunta']);
?>


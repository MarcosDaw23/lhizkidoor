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

<style>
    .results-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 20px;
    }

    .results-hero {
        background: linear-gradient(135deg, rgba(46, 213, 115, 0.1) 0%, rgba(29, 209, 161, 0.05) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(46, 213, 115, 0.2);
        border-radius: 30px;
        padding: 60px 50px;
        text-align: center;
        color: white;
        margin-bottom: 50px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        animation: fadeInDown 0.8s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .results-hero::before {
        content: '';
        position: absolute;
        top: -100%;
        left: -100%;
        width: 300%;
        height: 300%;
        background: radial-gradient(circle, rgba(46, 213, 115, 0.1) 0%, transparent 70%);
        animation: rotateGlow 20s linear infinite;
    }

    @keyframes rotateGlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .congrats-icon {
        font-size: 5rem;
        margin-bottom: 20px;
        animation: bounceIn 1s ease;
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3);
        }
        50% {
            transform: scale(1.05);
        }
        70% {
            transform: scale(0.9);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    .results-title {
        font-size: 3rem;
        font-weight: 900;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #2ed573 0%, #1dd1a1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        z-index: 1;
    }

    .results-subtitle {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-top: 30px;
        position: relative;
        z-index: 1;
    }

    .stat-box {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .stat-value {
        font-size: 3rem;
        font-weight: 900;
        color: white;
        margin-bottom: 10px;
    }

    .stat-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .questions-timeline {
        position: relative;
        padding-left: 40px;
    }

    .timeline-line {
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #2ed573 0%, #1dd1a1 100%);
        border-radius: 3px;
    }

    .question-item {
        position: relative;
        margin-bottom: 30px;
        animation: slideInRight 0.6s ease forwards;
        opacity: 0;
    }

    .question-item:nth-child(1) { animation-delay: 0.1s; }
    .question-item:nth-child(2) { animation-delay: 0.2s; }
    .question-item:nth-child(3) { animation-delay: 0.3s; }
    .question-item:nth-child(4) { animation-delay: 0.4s; }
    .question-item:nth-child(5) { animation-delay: 0.5s; }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .question-marker {
        position: absolute;
        left: -32px;
        top: 10px;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 0.9rem;
        color: white;
        z-index: 2;
    }

    .question-marker.correct {
        background: linear-gradient(135deg, #2ed573 0%, #1dd1a1 100%);
        box-shadow: 0 0 20px rgba(46, 213, 115, 0.5);
    }

    .question-marker.incorrect {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        box-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
    }

    .question-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .question-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #2ed573 0%, #1dd1a1 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .question-card.incorrect::before {
        background: linear-gradient(180deg, #ff6b6b 0%, #ee5a6f 100%);
    }

    .question-card:hover {
        transform: translateX(10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
    }

    .question-card:hover::before {
        opacity: 1;
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .question-title {
        font-size: 1rem;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .result-badge.correct {
        background: rgba(46, 213, 115, 0.2);
        color: #2ed573;
        border: 1px solid rgba(46, 213, 115, 0.3);
    }

    .result-badge.incorrect {
        background: rgba(255, 107, 107, 0.2);
        color: #ff6b6b;
        border: 1px solid rgba(255, 107, 107, 0.3);
    }

    .question-text {
        font-size: 1.2rem;
        color: white;
        line-height: 1.7;
        margin-bottom: 25px;
        font-weight: 500;
    }

    .answers-grid {
        display: grid;
        gap: 15px;
    }

    .answer-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px 20px;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .answer-item.your-answer {
        background: rgba(255, 107, 107, 0.1);
        border: 1px solid rgba(255, 107, 107, 0.3);
    }

    .answer-item.correct-answer {
        background: rgba(46, 213, 115, 0.1);
        border: 1px solid rgba(46, 213, 115, 0.3);
    }

    .answer-label {
        font-weight: 700;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.6);
        min-width: 100px;
    }

    .answer-value {
        flex: 1;
        font-weight: 600;
        font-size: 1.05rem;
        color: white;
    }

    .answer-icon {
        font-size: 1.5rem;
    }

    .answer-icon.correct {
        color: #2ed573;
    }

    .answer-icon.incorrect {
        color: #ff6b6b;
    }

    .action-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 50px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 18px 40px;
        border-radius: 18px;
        text-decoration: none;
        font-weight: 800;
        font-size: 1.1rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }

    .btn:hover::before {
        width: 300px;
        height: 300px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 10px 30px rgba(79, 172, 254, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(79, 172, 254, 0.6);
        color: white;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-5px);
        color: white;
    }

    .empty-state-results {
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px;
        position: relative;
    }

    .particles {
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 50px 50px;
        animation: particlesMove 20s linear infinite;
    }

    @keyframes particlesMove {
        0% { background-position: 0 0; }
        100% { background-position: 50px 50px; }
    }

    .empty-icon {
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 40px;
        font-size: 5rem;
        color: white;
        box-shadow: 0 20px 60px rgba(255, 107, 107, 0.4);
        position: relative;
        z-index: 1;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .empty-state-results h3 {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .empty-state-results p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
    }

    @media (max-width: 768px) {
        .results-hero {
            padding: 40px 30px;
        }

        .results-title {
            font-size: 2.2rem;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>

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


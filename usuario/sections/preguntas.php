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

<style>
    .game-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
    }

    .question-card {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(79, 172, 254, 0.05) 100%);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 35px;
        padding: 60px 50px;
        max-width: 900px;
        width: 100%;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        animation: slideInScale 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .question-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 107, 107, 0.05) 0%, transparent 70%);
        animation: rotateGlow 15s linear infinite;
    }

    @keyframes rotateGlow {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes slideInScale {
        from {
            opacity: 0;
            transform: translateY(50px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .question-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        z-index: 1;
    }

    .question-number {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        padding: 15px 35px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 1.2rem;
        margin-bottom: 30px;
        box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
      
    }
   


    .progress-bar-container {
        width: 100%;
        height: 12px;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 30px;
        position: relative;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #ff6b6b 0%, #4facfe 50%, #00f2fe 100%);
        border-radius: 10px;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 0 20px rgba(79, 172, 254, 0.6);
        position: relative;
        overflow: hidden;
    }

    .progress-bar-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .question-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #ffc039 0%, #ff6348 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 3.5rem;
        color: white;
        box-shadow: 0 15px 50px rgba(255, 192, 57, 0.5);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 15px 50px rgba(255, 192, 57, 0.5);
        }
        50% {
            transform: scale(1.08);
            box-shadow: 0 20px 60px rgba(255, 192, 57, 0.7);
        }
    }

    .definition-box {
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 35px;
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
    }

    .definition-box:hover {
        border-color: rgba(79, 172, 254, 0.4);
        box-shadow: 0 10px 40px rgba(79, 172, 254, 0.2);
    }

    .definition-label {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1rem;
        font-weight: 700;
        color: #4facfe;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 20px;
    }

    .definition-label i {
        font-size: 1.5rem;
    }

    .definition-text {
        font-size: 1.4rem;
        line-height: 1.8;
        color: white;
        font-weight: 500;
    }

    .options-container {
        display: grid;
        gap: 20px;
        margin-bottom: 35px;
        position: relative;
        z-index: 1;
    }

    .option-card {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 25px 30px;
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .option-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(79, 172, 254, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .option-card:hover {
        transform: translateX(5px);
        border-color: rgba(79, 172, 254, 0.5);
        background: rgba(79, 172, 254, 0.08);
    }

    .option-card:hover::before {
        left: 100%;
    }

    .option-card input[type="radio"] {
        display: none;
    }

    .option-card:has(input:checked) {
        border-color: #4facfe;
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.2) 0%, rgba(0, 242, 254, 0.1) 100%);
        box-shadow: 0 10px 40px rgba(79, 172, 254, 0.4);
        transform: translateX(3px) scale(1.02);
    }

    .option-label {
        font-size: 1.2rem;
        font-weight: 600;
        color: white;
        cursor: pointer;
        flex: 1;
    }

    .option-letter {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.5rem;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
    }

    .submit-button {
        width: 100%;
        padding: 22px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        border: none;
        border-radius: 20px;
        font-size: 1.3rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .submit-button::before {
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

    .submit-button:hover::before {
        width: 400px;
        height: 400px;
    }

    .submit-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(255, 107, 107, 0.6);
    }

    .submit-button i {
        font-size: 1.8rem;
    }

    .submit-button.final {
        background: linear-gradient(135deg, #2ed573 0%, #1dd1a1 100%);
        box-shadow: 0 15px 40px rgba(46, 213, 115, 0.4);
    }

    .submit-button.final:hover {
        box-shadow: 0 20px 50px rgba(46, 213, 115, 0.6);
    }

    .score-display {
        text-align: center;
        margin-top: 30px;
        padding: 20px;
        background: linear-gradient(135deg, rgba(255, 192, 57, 0.15) 0%, rgba(255, 99, 72, 0.15) 100%);
        border: 1px solid rgba(255, 192, 57, 0.3);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        position: relative;
        z-index: 1;
        animation: scoreGlow 2s ease-in-out infinite;
    }

    @keyframes scoreGlow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(255, 192, 57, 0.3);
        }
        50% {
            box-shadow: 0 0 30px rgba(255, 192, 57, 0.5);
        }
    }

    .score-display i {
        font-size: 2rem;
        color: #ffc039;
        animation: rotate 4s linear infinite;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .score-text {
        font-size: 1.3rem;
        font-weight: 800;
        color: white;
    }

    .empty-state-game {
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px;
        position: relative;
    }

    .empty-glow {
        position: absolute;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(255, 107, 107, 0.2) 0%, transparent 70%);
        border-radius: 50%;
        animation: expandGlow 3s ease-in-out infinite;
    }

    @keyframes expandGlow {
        0%, 100% {
            transform: scale(1);
            opacity: 0.5;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
    }

    .empty-icon {
        width: 140px;
        height: 140px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 40px;
        font-size: 5rem;
        color: white;
        box-shadow: 0 20px 60px rgba(255, 107, 107, 0.4);
        animation: bounce 2s ease-in-out infinite;
        position: relative;
        z-index: 1;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(-30px);
        }
        60% {
            transform: translateY(-15px);
        }
    }

    .empty-state-game h3 {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .empty-state-game p {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1.2rem;
        margin-bottom: 40px;
        max-width: 600px;
        position: relative;
        z-index: 1;
    }

    .btn-start-game {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 22px 50px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.3rem;
        transition: all 0.4s ease;
        box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
        position: relative;
        z-index: 1;
    }

    .btn-start-game:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 50px rgba(255, 107, 107, 0.6);
        color: white;
    }

    @media (max-width: 768px) {
        .game-container {
            padding: 12px;
        }
        .main-container {
            padding: 24px 16px;
        }
        .question-card {
            padding: 18px 12px;
            border-radius: 18px;
            max-width: 100vw;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .question-header {
            margin-bottom: 18px;
        }
        .question-number {
            padding: 12px 18px;
            font-size: 1.1rem;
            margin-bottom: 12px;
            border-radius: 24px;
            gap: 8px;
        }
        .progress-bar-container {
            height: 10px;
            margin-bottom: 12px;
        }
        .question-icon {
            width: 44px;
            height: 44px;
            font-size: 1.6rem;
            margin-bottom: 10px;
        }
        .definition-box {
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 14px;
        }
        .definition-label {
            font-size: 1rem;
            gap: 8px;
            margin-bottom: 8px;
        }
        .definition-label i {
            font-size: 1.2rem;
        }
        .definition-text {
            font-size: 1.15rem;
            line-height: 1.5;
        }
        .options-container {
            gap: 14px;
            margin-bottom: 14px;
        }
        .option-card {
            gap: 10px;
            padding: 14px 10px;
            border-radius: 12px;
        }
        .option-label {
            font-size: 1.15rem;
            font-weight: 600;
        }
        .option-letter {
            width: 32px;
            height: 32px;
            font-size: 1.2rem;
            border-radius: 8px;
        }
        .submit-button {
            padding: 14px;
            font-size: 1.15rem;
            border-radius: 12px;
            gap: 10px;
        }
        .submit-button i {
            font-size: 1.2rem;
        }
        .score-display {
            margin-top: 14px;
            padding: 10px;
            border-radius: 10px;
            gap: 10px;
        }
        .score-display i {
            font-size: 1.2rem;
        }
        .score-text {
            font-size: 1.15rem;
        }
    }
</style>

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

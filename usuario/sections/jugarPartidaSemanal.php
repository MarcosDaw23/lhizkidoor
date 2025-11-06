<?php
$palabra = $_SESSION['palabra'] ?? null;

if (!$palabra) {
    echo "<div class='error-state'>
            <div class='error-glow'></div>
            <div class='error-icon'>❌</div>
            <h3>No se encontró ninguna palabra</h3>
            <a href='./index.php?section=juegos' class='btn-error'>Volver a Juegos</a>
          </div>";
    exit;
}
?>

<style>
    .weekly-game-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
    }

    .weekly-game-container::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 192, 57, 0.15) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        animation: pulseGlow 4s ease-in-out infinite;
    }

    @keyframes pulseGlow {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 0.5;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
        }
    }

    .weekly-card {
        background: linear-gradient(135deg, rgba(255, 192, 57, 0.08) 0%, rgba(255, 107, 107, 0.05) 100%);
        backdrop-filter: blur(30px);
        border: 2px solid rgba(255, 192, 57, 0.2);
        border-radius: 35px;
        padding: 60px 50px;
        max-width: 950px;
        width: 100%;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
        animation: slideInUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(100px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .weekly-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(
            from 0deg,
            transparent 0deg,
            rgba(255, 192, 57, 0.1) 90deg,
            rgba(255, 107, 107, 0.1) 180deg,
            transparent 270deg
        );
        animation: rotateBg 8s linear infinite;
    }

    @keyframes rotateBg {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .weekly-header {
        text-align: center;
        margin-bottom: 50px;
        position: relative;
        z-index: 1;
    }

    .weekly-badge {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #ffc039 0%, #ff6348 100%);
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 900;
        font-size: 1.2rem;
        box-shadow: 0 15px 40px rgba(255, 192, 57, 0.5);
        margin-bottom: 35px;
        animation: bounceIn 1.2s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: scale(0.3) rotate(-10deg);
        }
        50% {
            transform: scale(1.05) rotate(5deg);
        }
        70% {
            transform: scale(0.95) rotate(-2deg);
        }
        100% {
            opacity: 1;
            transform: scale(1) rotate(0deg);
        }
    }

    .weekly-icon {
        font-size: 7rem;
        margin: 0 auto 20px;
        width: 150px;
        height: 150px;
        background: linear-gradient(135deg, rgba(255, 192, 57, 0.15) 0%, rgba(255, 99, 72, 0.15) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid rgba(255, 192, 57, 0.3);
        animation: spin 20s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .definition-container {
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 25px;
        padding: 40px;
        margin-bottom: 45px;
        position: relative;
        z-index: 1;
        transition: all 0.4s ease;
    }

    .definition-container:hover {
        border-color: rgba(255, 192, 57, 0.4);
        box-shadow: 0 15px 50px rgba(255, 192, 57, 0.2);
        transform: scale(1.02);
    }

    .definition-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        font-size: 1.1rem;
        font-weight: 800;
        color: #ffc039;
        text-transform: uppercase;
        letter-spacing: 3px;
        margin-bottom: 25px;
    }

    .definition-label i {
        font-size: 1.8rem;
    }

    .definition-text {
        font-size: 1.6rem;
        line-height: 1.9;
        color: white;
        font-weight: 600;
        text-align: center;
    }

    .options-grid {
        display: grid;
        gap: 25px;
        margin-bottom: 40px;
        position: relative;
        z-index: 1;
    }

    .option-wrapper {
        position: relative;
    }

    .option-input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    .option-label {
        display: flex;
        align-items: center;
        gap: 25px;
        padding: 28px 35px;
        background: rgba(255, 255, 255, 0.03);
        border: 2px solid rgba(255, 255, 255, 0.15);
        border-radius: 22px;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .option-label::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 192, 57, 0.1), transparent);
        transition: left 0.6s ease;
    }

    .option-label:hover {
        transform: translateX(15px);
        border-color: rgba(255, 192, 57, 0.5);
        background: rgba(255, 192, 57, 0.1);
    }

    .option-label:hover::before {
        left: 100%;
    }

    .option-input:checked + .option-label {
        border-color: #ffc039;
        background: linear-gradient(135deg, rgba(255, 192, 57, 0.2) 0%, rgba(255, 99, 72, 0.15) 100%);
        box-shadow: 0 15px 50px rgba(255, 192, 57, 0.4);
        transform: translateX(15px) scale(1.03);
    }

    .option-letter {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ffc039 0%, #ff6348 100%);
        color: white;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.8rem;
        flex-shrink: 0;
        box-shadow: 0 10px 30px rgba(255, 192, 57, 0.4);
        transition: all 0.3s ease;
    }

    .option-input:checked + .option-label .option-letter {
        transform: rotate(360deg) scale(1.1);
    }

    .option-radio {
        width: 30px;
        height: 30px;
        border: 3px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        position: relative;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .option-input:checked + .option-label .option-radio {
        border-color: #ffc039;
        background: linear-gradient(135deg, #ffc039 0%, #ff6348 100%);
        box-shadow: 0 0 20px rgba(255, 192, 57, 0.6);
    }

    .option-input:checked + .option-label .option-radio::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: 900;
        font-size: 1.2rem;
    }

    .option-text {
        flex: 1;
        font-size: 1.3rem;
        font-weight: 700;
        color: white;
        transition: all 0.3s ease;
    }

    .option-input:checked + .option-label .option-text {
        color: #ffc039;
    }

    .submit-btn {
        width: 100%;
        padding: 25px;
        background: linear-gradient(135deg, #ffc039 0%, #ff6348 100%);
        color: white;
        border: none;
        border-radius: 22px;
        font-size: 1.4rem;
        font-weight: 900;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        box-shadow: 0 20px 50px rgba(255, 192, 57, 0.5);
        position: relative;
        z-index: 1;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .submit-btn::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }

    .submit-btn:hover::before {
        width: 500px;
        height: 500px;
    }

    .submit-btn:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 60px rgba(255, 192, 57, 0.7);
    }

    .submit-btn i {
        font-size: 2rem;
    }

    .error-state {
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px;
        position: relative;
    }

    .error-glow {
        position: absolute;
        width: 500px;
        height: 500px;
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
            transform: scale(1.3);
            opacity: 0.8;
        }
    }

    .error-icon {
        width: 160px;
        height: 160px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 40px;
        font-size: 6rem;
        box-shadow: 0 25px 60px rgba(255, 107, 107, 0.5);
        animation: shake 1s ease;
        position: relative;
        z-index: 1;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
        20%, 40%, 60%, 80% { transform: translateX(10px); }
    }

    .error-state h3 {
        color: white;
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .btn-error {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 20px 45px;
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        text-decoration: none;
        border-radius: 20px;
        font-weight: 800;
        font-size: 1.2rem;
        transition: all 0.4s ease;
        box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
        position: relative;
        z-index: 1;
    }

    .btn-error:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 50px rgba(255, 107, 107, 0.6);
        color: white;
    }

    @media (max-width: 768px) {
        .weekly-card {
            padding: 40px 25px;
        }

        .weekly-icon {
            font-size: 5rem;
            width: 120px;
            height: 120px;
        }

        .definition-text {
            font-size: 1.3rem;
        }

        .option-text {
            font-size: 1.1rem;
        }

        .submit-btn {
            font-size: 1.2rem;
        }
    }
</style>

<div class="weekly-game-container">
    <div class="weekly-card">
        <div class="weekly-header">
            <div class="weekly-badge">
                <i class="bi bi-trophy-fill"></i>
                <span>Partida Semanal</span>
            </div>

            <div class="weekly-icon">
                🎯
            </div>
        </div>

        <div class="definition-container">
            <div class="definition-label">
                <i class="bi bi-book-fill"></i>
                <span>Definición</span>
            </div>
            <div class="definition-text">
                <?= htmlspecialchars($palabra['definicion']) ?>
            </div>
        </div>

        <form action="./controllers/PartidaSemanal_controller.php?action=verificar" method="POST">
            <input type="hidden" name="id" value="<?= $palabra['id'] ?>">

            <div class="options-grid">
                <?php
                    $opciones = [
                        1 => $palabra['eusk1'],
                        2 => $palabra['eusk2'],
                        3 => $palabra['eusk3']
                    ];
                    asort($opciones);
                    $letras = ['A', 'B', 'C'];
                    $index = 0;
                    foreach ($opciones as $key => $value):
                ?>
                    <div class="option-wrapper">
                        <input type="radio" 
                               name="opcion" 
                               id="op<?= $key ?>" 
                               value="<?= $key ?>" 
                               class="option-input" 
                               required>
                        <label for="op<?= $key ?>" class="option-label">
                            <div class="option-letter"><?= $letras[$index] ?></div>
                            <div class="option-radio"></div>
                            <div class="option-text"><?= htmlspecialchars($value) ?></div>
                        </label>
                    </div>
                <?php 
                    $index++;
                    endforeach; 
                ?>
            </div>

            <button type="submit" class="submit-btn">
                <i class="bi bi-check-circle-fill"></i>
                <span>Enviar Respuesta</span>
            </button>
        </form>
    </div>
</div>

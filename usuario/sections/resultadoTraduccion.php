<?php
$datos = $_SESSION['resultado_traduccion'] ?? null;

if (!$datos) {
    header("Location: ../index.php?section=traduccionJuego");
    exit;
}

// Determinar si es correcto o incorrecto
$esCorrecto = (strtolower(trim($datos['tu_respuesta'])) === strtolower(trim($datos['correcta'])));
?>

<style>
    .resultado-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 20px;
    }

    .resultado-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        padding: 60px 50px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        max-width: 700px;
        width: 100%;
        position: relative;
        overflow: hidden;
        animation: fadeInScale 0.8s ease;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .resultado-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 107, 107, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
        z-index: 0;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .resultado-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        position: relative;
        z-index: 1;
        animation: iconPulse 2s ease-in-out infinite;
    }

    @keyframes iconPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .resultado-icon.correcto {
        background: linear-gradient(135deg, #2ed573 0%, #7bed9f 100%);
        color: white;
        box-shadow: 0 15px 40px rgba(46, 213, 115, 0.4);
    }

    .resultado-icon.incorrecto {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
    }

    .resultado-titulo {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        animation: textGlow 3s ease-in-out infinite;
    }

    .resultado-titulo.correcto {
        background: linear-gradient(135deg, #2ed573 0%, #7bed9f 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .resultado-titulo.incorrecto {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    @keyframes textGlow {
        0%, 100% {
            filter: drop-shadow(0 0 10px rgba(255, 107, 107, 0.5));
        }
        50% {
            filter: drop-shadow(0 0 20px rgba(79, 172, 254, 0.8));
        }
    }

    .resultado-detalle {
        background: rgba(255, 255, 255, 0.6);
        border-radius: 20px;
        padding: 30px;
        margin: 30px 0;
        position: relative;
        z-index: 1;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .respuesta-item {
        margin: 20px 0;
        padding: 20px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .respuesta-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .respuesta-label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .respuesta-texto {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }

    .respuesta-item.tu-respuesta {
        border-left: 4px solid #4facfe;
    }

    .respuesta-item.respuesta-correcta {
        border-left: 4px solid #2ed573;
    }

    .botones-container {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 40px;
        position: relative;
        z-index: 1;
        flex-wrap: wrap;
    }

    .btn-resultado {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 18px 40px;
        font-size: 1.1rem;
        font-weight: 700;
        border: none;
        border-radius: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
    }

    .btn-primary-custom:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
        color: white;
    }

    .btn-secondary-custom {
        background: rgba(255, 255, 255, 0.8);
        color: #64748b;
        border: 2px solid #e2e8f0;
    }

    .btn-secondary-custom:hover {
        background: white;
        color: #475569;
        border-color: #cbd5e1;
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .resultado-card {
            padding: 40px 30px;
        }

        .resultado-titulo {
            font-size: 2rem;
        }

        .resultado-icon {
            width: 90px;
            height: 90px;
            font-size: 3rem;
        }

        .respuesta-texto {
            font-size: 1.2rem;
        }

        .botones-container {
            flex-direction: column;
        }

        .btn-resultado {
            width: 100%;
            justify-content: center;
        }
    }
</style>

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

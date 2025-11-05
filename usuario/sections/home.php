<?php
require_once __DIR__ . '/../../core/config.php';

$yaJugo = $_SESSION['yaJugo'] ?? false;
$nombreUsuario = $_SESSION['user']['nombre'] ?? 'Usuario';
?>

<style>
    .hero-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 60px 40px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        margin-bottom: 40px;
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-greeting {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 40px;
        font-weight: 500;
    }

    .play-button {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 25px 50px;
        font-size: 1.3rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .play-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .play-button:hover::before {
        width: 300px;
        height: 300px;
    }

    .play-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.5);
        color: white;
    }

    .play-button i {
        font-size: 2rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    .secondary-button {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 18px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        background: white;
        color: #667eea;
        border: 2px solid #667eea;
        border-radius: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .secondary-button:hover {
        background: #667eea;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        border-radius: 50px;
        font-weight: 600;
        margin-bottom: 30px;
        font-size: 1rem;
    }

    .status-badge.success {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .status-badge.warning {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .stat-card:nth-child(1) .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .stat-title {
        font-size: 0.95rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        color: #333;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 40px 25px;
        }

        .hero-greeting {
            font-size: 2rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }

        .play-button {
            padding: 20px 35px;
            font-size: 1.1rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="hero-section">
    <h1 class="hero-greeting">
        ¡Kaixo, <?= htmlspecialchars($nombreUsuario) ?>!
    </h1>

  <?php if (!$yaJugo): ?>
        <div class="status-badge warning">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>Aún no has jugado esta semana</span>
        </div>
        
        <p class="hero-subtitle">
            Pon a prueba tus conocimientos de euskera técnico.<br>
            ¡Demuestra lo que sabes y escala en el ranking!
        </p>

        <a href="./controllers/PartidaSemanal_controller.php?action=jugar" class="play-button">
            <i class="bi bi-play-circle-fill"></i>
            <span>Jugar Partida Semanal</span>
    </a>
  <?php else: ?>
        <div class="status-badge success">
            <i class="bi bi-check-circle-fill"></i>
            <span>Ya completaste la partida de esta semana</span>
        </div>
        
        <p class="hero-subtitle">
            ¡Excelente trabajo! Ya jugaste esta semana.<br>
            Puedes repasar o explorar otras secciones.
        </p>

        <a href="./controllers/PartidaSemanal_controller.php?action=repasar" class="secondary-button">
            <i class="bi bi-arrow-repeat"></i>
            <span>Repasar Preguntas</span>
    </a>
  <?php endif; ?>
</div>

<!-- Estadísticas rápidas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">
            <i class="bi bi-star-fill"></i>
        </div>
        <div class="stat-title">Tu Puntuación</div>
        <div class="stat-value"><?= $_SESSION['user']['puntuacionIndividual'] ?? 0 ?></div>
    </div>
</div>


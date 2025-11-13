<?php
require_once __DIR__ . '/../../core/config.php';

$yaJugo = $_SESSION['yaJugo'] ?? false;
$nombreUsuario = $_SESSION['user']['nombre'] ?? 'Usuario';
?>

<style>
    .hero-section {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 30px;
        padding: 80px 50px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        margin-bottom: 50px;
        position: relative;
        overflow: visible;
        animation: fadeInScale 0.8s ease;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 107, 107, 0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }

    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .hero-greeting {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 50%, #00f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        animation: textGlow 3s ease-in-out infinite;
    }

    @keyframes textGlow {
        0%, 100% {
            filter: drop-shadow(0 0 10px rgba(255, 107, 107, 0.5));
        }
        50% {
            filter: drop-shadow(0 0 20px rgba(79, 172, 254, 0.8));
        }
    }

    .hero-subtitle {
        font-size: 1.3rem;
        color: #666;
        margin-bottom: 50px;
        font-weight: 500;
        position: relative;
        z-index: 1;
        line-height: 1.8;
    }

    .play-button {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        padding: 30px 60px;
        font-size: 1.4rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        border: none;
        border-radius: 25px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 15px 50px rgba(255, 107, 107, 0.4);
        position: relative;
        z-index: 1;
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
        background: rgba(255, 255, 255, 0.2);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .play-button:hover::before {
        width: 400px;
        height: 400px;
    }

    .play-button:hover {
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 20px 60px rgba(255, 107, 107, 0.6);
        color: white;
    }

    .play-button i {
        font-size: 2.5rem;
    }

    .secondary-button {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        padding: 22px 45px;
        font-size: 1.2rem;
        font-weight: 700;
        background: rgba(255, 255, 255, 0.05);
        color: #666;
        border: 2px solid rgba(79, 172, 254, 0.5);
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        z-index: 1;
    }

    .secondary-button:hover {
        background: rgba(79, 172, 254, 0.2);
        border-color: #4facfe;
        color: #666;
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(79, 172, 254, 0.4);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        border-radius: 50px;
        font-weight: 700;
        margin-bottom: 30px;
        font-size: 1.1rem;
        position: relative;
        z-index: 1;
        animation: pulse 2s ease-in-out infinite;
    }

    .status-badge.success {
        background: rgba(46, 213, 115, 0.15);
        color: #2ed573;
        border: 1px solid rgba(46, 213, 115, 0.3);
        box-shadow: 0 0 30px rgba(46, 213, 115, 0.3);
    }

    .status-badge.warning {
        background: rgba(255, 192, 57, 0.15);
        color: #ffc039;
        border: 1px solid rgba(255, 192, 57, 0.3);
        box-shadow: 0 0 30px rgba(255, 192, 57, 0.3);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 50px;
    }

    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 40px 30px;
        border-radius: 25px;
        text-align: center;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 1s ease;
        position: relative;
        overflow: hidden;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(40px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1) 0%, rgba(79, 172, 254, 0.1) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
        border-color: rgba(255, 107, 107, 0.5);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-icon {
        width: 90px;
        height: 90px;
        margin: 0 auto 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        position: relative;
        z-index: 1;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    .stat-card:nth-child(1) .stat-icon {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
    }

    .stat-card:nth-child(2) .stat-icon {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 15px 40px rgba(79, 172, 254, 0.4);
    }

    .stat-card:nth-child(3) .stat-icon {
        background: linear-gradient(135deg, #ffc039 0%, #ff6348 100%);
        color: white;
        box-shadow: 0 15px 40px rgba(255, 192, 57, 0.4);
    }

    .stat-title {
        font-size: 1rem;
        color:#666;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        margin-bottom: 15px;
        position: relative;
        z-index: 1;
    }

    .stat-value {
        font-size: 3rem;
        font-weight: 900;
        color: #666;
        position: relative;
        z-index: 1;
        text-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
    }

    .greeting-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        position: relative;
    }

    .settings-icon-mobile {
        display: none;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        text-decoration: none;
        position: absolute;
        top: 20px;
        right: 20px;
        z-index: 10;
    }

    .settings-icon-mobile:hover {
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        color: white;
    }

    @media (max-width: 768px) {
        .hero-section {
            padding: 50px 30px;
        }

        .hero-greeting {
            font-size: 2.5rem;
        }

        .greeting-container {
            flex-wrap: wrap;
        }

        .settings-icon-mobile {
            display: flex;
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
            top: 15px;
            right: 15px;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .play-button {
            padding: 25px 40px;
            font-size: 1.2rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="hero-section">
    <!-- Botón de configuración en esquina superior derecha -->
    <a href="./index.php?section=perfil" class="settings-icon-mobile" title="Configuración">
        <i class="bi bi-gear-fill"></i>
    </a>

    <div class="greeting-container">
        <h1 class="hero-greeting">
            ¡Kaixo, <?= htmlspecialchars($nombreUsuario) ?>!
        </h1>
    </div>

  <?php if (!$yaJugo): ?>
        <div class="status-badge warning">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>Aún no has jugado esta semana</span>
        </div>

        <p class="hero-subtitle">
            Pon a prueba tus conocimientos de euskera técnico<br>
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
            ¡Excelente trabajo! Ya jugaste esta semana<br>
            Puedes repasar o explorar otras secciones
        </p>

        <a href="./index.php?section=juegos" class="secondary-button">
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
        <div class="stat-value"><?= $_SESSION['user']['puntuacion'] ?? 0 ?></div>
    </div>
</div>

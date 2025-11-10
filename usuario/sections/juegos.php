<?php
$yaJugo = $_SESSION['yaJugo'] ?? false;
?>

<style>
    .games-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        position: relative;
    }

    /* Elementos decorativos de fondo */
    .games-container::before,
    .games-container::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        z-index: -1;
        opacity: 0.1;
    }

    .games-container::before {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        top: -100px;
        right: -50px;
        animation: float 6s ease-in-out infinite;
    }

    .games-container::after {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        bottom: 100px;
        left: -50px;
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-30px) rotate(10deg); }
    }

    /* Status Badge Mejorado */
    .status-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 40px;
        margin-bottom: 50px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        text-align: center;
        border: 2px solid rgba(255, 255, 255, 0.5);
        position: relative;
        overflow: hidden;
    }

    .status-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(
            transparent,
            rgba(102, 126, 234, 0.3),
            transparent 30%
        );
        animation: rotate 6s linear infinite;
    }

    @keyframes rotate {
        100% { transform: rotate(360deg); }
    }

    .status-card-content {
        position: relative;
        z-index: 1;
    }

    .status-icon {
        width: 100px;
        height: 100px;
        margin: 0 auto 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .status-icon.available {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        animation: bounce 2s infinite, glow 2s ease-in-out infinite;
    }

    .status-icon.played {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    @keyframes glow {
        0%, 100% { box-shadow: 0 10px 30px rgba(79, 172, 254, 0.4); }
        50% { box-shadow: 0 10px 50px rgba(79, 172, 254, 0.8); }
    }

    .status-message {
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .countdown-container {
        margin-top: 25px;
    }

    .countdown-label {
        font-size: 1.1rem;
        color: #666;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .countdown-display {
        display: inline-flex;
        gap: 20px;
        padding: 25px 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(102, 126, 234, 0.4);
        position: relative;
        overflow: hidden;
    }

    .countdown-display::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        100% { left: 100%; }
    }

    .countdown-unit {
        display: flex;
        flex-direction: column;
        align-items: center;
        min-width: 70px;
        position: relative;
    }

    .countdown-number {
        font-size: 2.5rem;
        font-weight: 900;
        color: white;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .countdown-text {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.9);
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-top: 8px;
        font-weight: 700;
    }

    /* Botón Juega Ahora */
    .play-now-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 18px 40px;
        font-size: 1.15rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
    }

    .play-now-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        transition: left 0.5s ease;
    }

    .play-now-btn:hover::before {
        left: 100%;
    }

    .play-now-btn:hover {
        transform: translateY(-5px) scale(1.05);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.6);
    }

    .play-now-btn:active {
        transform: translateY(-2px) scale(1.02);
    }

    /* Games Grid */
    .games-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-top: 40px;
    }

    .game-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 40px;
        text-decoration: none;
        color: inherit;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border: 2px solid transparent;
    }

    .game-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: var(--card-gradient);
        transform: scaleX(0);
        transition: transform 0.5s ease;
    }

    .game-card:hover::after {
        transform: scaleX(1);
    }

    .game-card:hover {
        transform: translateY(-15px) rotate(2deg);
        box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
        border-color: var(--card-border);
    }

    /* Tarjeta destacada para partida semanal */
    .game-card.featured {
        grid-column: 1 / -1;
        background: var(--card-gradient);
        color: white;
        padding: 60px;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .game-card.featured::before {
        content: '';
        position: absolute;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -100px;
        right: -100px;
        animation: float 5s ease-in-out infinite;
    }

    .game-card.featured:hover {
        transform: translateY(-15px) scale(1.03);
        box-shadow: 0 30px 70px rgba(0, 0, 0, 0.3);
    }

    /* Estilos específicos por juego */
    .game-card.semanal {
        --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-border: #667eea;
    }

    .game-card.practica {
        --card-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --card-border: #f093fb;
    }

    .game-card.traduccion {
        --card-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --card-border: #4facfe;
    }

    .game-card.ahorcado {
        --card-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --card-border: #fa709a;
    }

    .game-icon-wrapper {
        position: relative;
        margin-bottom: 25px;
    }

    .game-icon {
        width: 110px;
        height: 110px;
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.5rem;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        z-index: 1;
    }

    .game-card:not(.featured) .game-icon {
        background: var(--card-gradient);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .game-card.featured .game-icon {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        width: 140px;
        height: 140px;
        font-size: 5rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .game-card:hover .game-icon {
        transform: scale(1.15) rotate(-10deg);
    }

    .game-title {
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .game-card.featured .game-title {
        font-size: 2.5rem;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .game-description {
        font-size: 1rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 25px;
        flex-grow: 1;
    }

    .game-card.featured .game-description {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.95);
    }

    .game-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .badge-available {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        color: white;
        animation: pulse-badge 2s infinite;
    }

    @keyframes pulse-badge {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .badge-popular {
        background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 90%);
        color: white;
    }

    .badge-new {
        background: linear-gradient(135deg, #FFA07A 0%, #FF6347 100%);
        color: white;
    }

    .badge-soon {
        background: linear-gradient(135deg, #c3cfe2 0%, #c3cfe2 100%);
        color: #666;
    }

    .game-card.featured .game-badge {
        background: rgba(255, 255, 255, 0.95);
        color: #667eea;
    }

    .game-stats {
        display: flex;
        gap: 20px;
        margin-top: 15px;
        justify-content: center;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: inherit;
    }

    .stat-label {
        font-size: 0.75rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    @media (max-width: 768px) {
        .games-grid {
            grid-template-columns: 1fr;
        }

        .game-card.featured {
            grid-column: 1;
            padding: 40px 30px;
        }

        .countdown-display {
            gap: 12px;
            padding: 20px 25px;
        }

        .countdown-unit {
            min-width: 55px;
        }

        .countdown-number {
            font-size: 2rem;
        }

        .game-icon {
            width: 90px;
            height: 90px;
            font-size: 3rem;
        }

        .game-card.featured .game-icon {
            width: 110px;
            height: 110px;
            font-size: 4rem;
        }
    }
</style>

<div class="games-container">
    <!-- Estado de la partida semanal -->
    <?php if (!$yaJugo): ?>
        <div class="status-card">
            <div class="status-card-content">
                <div class="status-icon available">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="status-message">¡Partida Semanal Disponible!</div>
                <p style="color: #666; font-size: 1.05rem; margin-bottom: 25px;">Completa el desafío de esta semana y suma puntos al ranking</p>
                <a href="./controllers/PartidaSemanal_controller.php?action=jugar" class="play-now-btn">
                    <i class="bi bi-play-fill"></i> ¡Juega Ahora!
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="status-card">
            <div class="status-card-content">
                <div class="status-icon played">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="status-message">¡Partida Completada!</div>
                <div class="countdown-container">
                    <p class="countdown-label">⏰ Próxima partida disponible en:</p>
                    <div id="cronometro" class="countdown-display">
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text">Días</div>
                        </div>
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text">Horas</div>
                        </div>
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text">Min</div>
                        </div>
                        <div class="countdown-unit">
                            <div class="countdown-number">-</div>
                            <div class="countdown-text">Seg</div>
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
            <h3 class="game-title">Práctica Libre</h3>
            <p class="game-description">
                Entrena con preguntas ilimitadas sin presión. Mejora tu vocabulario técnico en euskera.
            </p>
            <span class="game-badge badge-popular">
                <i class="bi bi-fire"></i> Más Popular
            </span>
        </a>

        <!-- Traducción -->
        <a href="./controllers/nsq_controller.php" class="game-card traduccion">
            <div class="game-icon-wrapper">
                <div class="game-icon">
                    ✍️
                </div>
            </div>
            <h3 class="game-title">Traducción Rápida</h3>
            <p class="game-description">
                Escribe la palabra correcta en castellano. Pon a prueba tu velocidad y precisión.
            </p>
            <span class="game-badge badge-new">
                <i class="bi bi-stars"></i> Nuevo
            </span>
        </a>

        <!-- Ahorcado -->
        <a href="./controllers/nsq_controller.php" class="game-card ahorcado">
            <div class="game-icon-wrapper">
                <div class="game-icon">
                    🎯
                </div>
            </div>
            <h3 class="game-title">Ahorcado Técnico</h3>
            <p class="game-description">
                Adivina la palabra letra por letra. Un clásico con vocabulario profesional.
            </p>
            <span class="game-badge badge-soon">
                <i class="bi bi-clock"></i> Próximamente
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

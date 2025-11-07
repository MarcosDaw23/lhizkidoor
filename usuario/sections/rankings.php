<?php

if (!isset($_SESSION['user'])) {
    header('Location: ../../auth/index.php?section=login');
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';
$bd = new AccesoBD_Usuario();

$centroId = $_SESSION['user']['centro'];
$centroData = $bd->obtenerCentroById($centroId);

if (is_array($centroData)) {
    $nombreCentro = $centroData['nombre'] ?? 'Desconocido';
} else {
    $nombreCentro = $centroData ?? 'Desconocido';
}
?>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: rgb(61, 77, 148);
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 100px;
            position: relative;
            margin: 0;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(255, 107, 107, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(79, 172, 254, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(250, 139, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.03) 4px);
            pointer-events: none;
            z-index: 0;
        }

        /* Navbar Desktop */
        .navbar-desktop {
            background: rgba(15, 15, 35, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            padding: 20px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-desktop .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 2.2rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 50%, #00f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            filter: drop-shadow(0 0 20px rgba(255, 107, 107, 0.4));
        }

        .navbar-brand i {
            font-size: 2rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .navbar-menu {
            display: flex;
            gap: 12px;
            align-items: center;
            list-style: none;
            margin: 0;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.2) 0%, rgba(79, 172, 254, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-link-custom:hover {
            color: white;
            transform: translateY(-2px);
        }

        .nav-link-custom:hover::before {
            opacity: 1;
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .nav-link-custom i {
            font-size: 1.2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .user-name {
            color: white;
            font-size: 0.95rem;
        }

        /* Botón de logout */
        .btn-logout {
            padding: 10px 20px;
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: #ff6b6b;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-logout::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-logout:hover {
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.5);
        }

        .btn-logout:hover::before {
            left: 0;
        }

        /* Barra de navegación inferior móvil */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -8px 32px rgba(0, 0, 0, 0.5);
            padding: 15px 0;
            z-index: 1000;
        }

        .mobile-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 0 10px;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
            border-radius: 12px;
            min-width: 60px;
            position: relative;
        }

        .mobile-nav-item i {
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .mobile-nav-item span {
            font-size: 0.7rem;
            font-weight: 600;
        }

        .mobile-nav-item.active {
            color: white;
        }

        .mobile-nav-item.active::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b 0%, #4facfe 100%);
            border-radius: 3px 3px 0 0;
            box-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
        }

        .mobile-nav-item.active i {
            transform: scale(1.15);
            color: #4facfe;
        }

        .mobile-nav-item:hover {
            color: white;
        }

        .ranking-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .ranking-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            text-align: center;
        }

        .ranking-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .ranking-header .subtitle {
            font-size: 1.1rem;
            color: #666;
            font-weight: 500;
        }

        .ranking-header .center-name {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 15px;
        }

        .category-tabs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .category-btn {
            background: white;
            border: none;
            padding: 0;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.4s ease;
            z-index: 0;
        }

        .category-btn:nth-child(1)::before {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .category-btn:nth-child(2)::before {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .category-btn:nth-child(3)::before {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .category-btn:nth-child(4)::before {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .category-btn-content {
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 1;
        }

        .category-btn i {
            font-size: 3rem;
            transition: all 0.4s ease;
        }

        .category-btn:nth-child(1) i {
            color: #667eea;
        }

        .category-btn:nth-child(2) i {
            color: #f5576c;
        }

        .category-btn:nth-child(3) i {
            color: #4facfe;
        }

        .category-btn:nth-child(4) i {
            color: #43e97b;
        }

        .category-btn span {
            font-size: 1rem;
            font-weight: 700;
            text-align: center;
            transition: all 0.3s ease;
            color: #333;
        }

        .category-btn:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .category-btn:hover i {
            transform: scale(1.2) rotate(10deg);
        }

        .category-btn.active::before {
            opacity: 1;
        }

        .category-btn.active {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
        }

        .category-btn.active i,
        .category-btn.active span {
            color: white;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .category-btn.active i {
            transform: scale(1.3);
            animation: iconBounce 0.6s ease;
        }

        @keyframes iconBounce {
            0%, 100% { transform: scale(1.3) translateY(0); }
            50% { transform: scale(1.3) translateY(-10px); }
        }

        .ranking-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ranking-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .ranking-item {
            background: white;
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            position: relative;
            overflow: hidden;
        }

        .ranking-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .ranking-item:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .ranking-item:hover::before {
            opacity: 1;
        }

        .ranking-position {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(250, 139, 255, 0.1) 0%, rgba(43, 210, 255, 0.1) 100%);
            font-weight: 800;
            font-size: 1.3rem;
            color: #666;
            position: relative;
        }

        .ranking-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .ranking-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
        }

        .ranking-subtitle {
            font-size: 0.85rem;
            color: #999;
            font-weight: 500;
        }

        /* Medallas para top 3 */
        .ranking-item:nth-child(1) .ranking-position {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        .ranking-item:nth-child(1) .ranking-position::after {
            content: '🥇';
            position: absolute;
            font-size: 1.8rem;
        }

        .ranking-item:nth-child(1)::before {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            width: 5px;
            opacity: 1;
        }

        .ranking-item:nth-child(2) .ranking-position {
            background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 100%);
            color: white;
            font-size: 1.4rem;
            box-shadow: 0 4px 15px rgba(192, 192, 192, 0.4);
        }

        .ranking-item:nth-child(2) .ranking-position::after {
            content: '🥈';
            position: absolute;
            font-size: 1.6rem;
        }

        .ranking-item:nth-child(2)::before {
            background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 100%);
            width: 5px;
            opacity: 1;
        }

        .ranking-item:nth-child(3) .ranking-position {
            background: linear-gradient(135deg, #CD7F32 0%, #B8860B 100%);
            color: white;
            font-size: 1.3rem;
            box-shadow: 0 4px 15px rgba(205, 127, 50, 0.4);
        }

        .ranking-item:nth-child(3) .ranking-position::after {
            content: '🥉';
            position: absolute;
            font-size: 1.5rem;
        }

        .ranking-item:nth-child(3)::before {
            background: linear-gradient(135deg, #CD7F32 0%, #B8860B 100%);
            width: 5px;
            opacity: 1;
        }

        .score-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(250, 139, 255, 0.2);
            border-top-color: #FA8BFF;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-desktop {
                display: none;
            }

            .mobile-bottom-nav {
                display: block;
            }

            body {
                padding: 15px;
                padding-bottom: 100px;
            }

            .ranking-header h1 {
                font-size: 2rem;
            }

            .category-tabs {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 30px;
            }

            .category-btn {
                transform: none !important;
            }

            .category-btn:hover {
                transform: translateY(-5px) scale(1.02) !important;
            }

            .category-btn.active {
                transform: translateY(-5px) scale(1.02) !important;
            }

            .category-btn-content {
                padding: 22px 15px;
                gap: 10px;
            }

            .category-btn i {
                font-size: 2.2rem;
            }

            .category-btn span {
                font-size: 0.85rem;
                line-height: 1.2;
            }

            .ranking-item {
                padding: 16px;
                gap: 12px;
            }

            .ranking-position {
                min-width: 42px;
                height: 42px;
                font-size: 1.1rem;
            }

            .ranking-name {
                font-size: 1rem;
            }

            .ranking-subtitle {
                font-size: 0.75rem;
            }

            .score-badge {
                font-size: 1rem;
                padding: 8px 16px;
            }
        }

        @media (min-width: 769px) {
            .navbar-desktop {
                display: block;
            }

            .mobile-bottom-nav {
                display: none;
            }

            body {
                padding-bottom: 0;
            }

            .ranking-container {
                padding: 20px;
            }
        }
    </style>


<body>
    

    <!-- Mobile Bottom Nav -->
    <nav class="mobile-bottom-nav">
        <div class="mobile-nav-items">
            <a href="../index.php" class="mobile-nav-item">
                <i class="bi bi-house-fill"></i>
                <span>Inicio</span>
            </a>
            <a href="../index.php?section=juegos" class="mobile-nav-item">
                <i class="bi bi-controller"></i>
                <span>Juegos</span>
            </a>
            <a href="rankings.php" class="mobile-nav-item active">
                <i class="bi bi-trophy-fill"></i>
                <span>Ranking</span>
            </a>
            <a href="../controllers/obtenerGlosario_controller.php" class="mobile-nav-item">
                <i class="bi bi-journal-text"></i>
                <span>Glosario</span>
            </a>
            <a href="../../auth/controllers/logout_controller.php" class="mobile-nav-item">
                <i class="bi bi-box-arrow-right"></i>
                <span>Salir</span>
            </a>
        </div>
    </nav>

    <div class="ranking-container">
        <!-- Header -->
        <div class="ranking-header">
            <h1><i class="bi bi-trophy-fill"></i> Rankings</h1>
            <p class="subtitle">Compite con los mejores y alcanza la cima</p>
            <div class="center-name">
                <i class="bi bi-building"></i>
                <span><?= htmlspecialchars($nombreCentro, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="category-tabs">
            <button class="category-btn active" onclick="cambiarRanking('ramas')" data-category="ramas">
                <div class="category-btn-content">
                    <i class="bi bi-diagram-3-fill"></i>
                    <span>Familia Formativa</span>
                </div>
            </button>
            <button class="category-btn" onclick="cambiarRanking('sectores')" data-category="sectores">
                <div class="category-btn-content">
                    <i class="bi bi-mortarboard-fill"></i>
                    <span>Grado</span>
                </div>
            </button>
            <button class="category-btn" onclick="cambiarRanking('clases')" data-category="clases">
                <div class="category-btn-content">
                    <i class="bi bi-people-fill"></i>
                    <span>Clases</span>
                </div>
            </button>
            <button class="category-btn" onclick="cambiarRanking('individual')" data-category="individual">
                <div class="category-btn-content">
                    <i class="bi bi-person-fill"></i>
                    <span>Individual</span>
                </div>
            </button>
        </div>

        <!-- Ranking Table -->
        <div class="ranking-card">
            <div id="ranking-table">
                <?php
                $datos = $bd->obtenerRankingRamas($_SESSION['user']['centro']);
                
                if (empty($datos)) {
                    echo '<div class="empty-state">';
                    echo '<i class="bi bi-inbox"></i>';
                    echo '<h3>No hay datos disponibles</h3>';
                    echo '<p>Aún no hay puntuaciones registradas en esta categoría.</p>';
                    echo '</div>';
                } else {
                    echo '<div class="ranking-list">';
                    $position = 1;
                    foreach ($datos as $fila) {
                        echo '<div class="ranking-item">';
                        echo '<div class="ranking-position">' . $position . '</div>';
                        echo '<div class="ranking-info">';
                        echo '<div class="ranking-name">' . htmlspecialchars($fila['rama']) . '</div>';
                        echo '<div class="ranking-subtitle">Familia Formativa</div>';
                        echo '</div>';
                        echo '<span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionRanking']) . '</span>';
                        echo '</div>';
                        $position++;
                    }
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function cambiarRanking(categoria) {
            // Actualizar botones activos
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-category="${categoria}"]`).classList.add('active');

            // Mostrar loading
            document.getElementById('ranking-table').innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner"></div>
                </div>
            `;

            // Hacer petición AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('GET', './sections/ranking_ajax.php?categoria=' + categoria, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('ranking-table').innerHTML = this.responseText;
                } else {
                    document.getElementById('ranking-table').innerHTML = `
                        <div class="empty-state">
                            <i class="bi bi-exclamation-triangle"></i>
                            <h3>Error al cargar datos</h3>
                            <p>Por favor, intenta de nuevo.</p>
                        </div>
                    `;
                }
            };
            xhr.onerror = function() {
                document.getElementById('ranking-table').innerHTML = `
                    <div class="empty-state">
                        <i class="bi bi-wifi-off"></i>
                        <h3>Error de conexión</h3>
                        <p>Por favor, verifica tu conexión a internet.</p>
                    </div>
                `;
            };
            xhr.send();
        }
    </script>
</body>
</html>
<?php
if (!isset($_SESSION['user'])) {
    header('Location: ../../auth/index.php?section=login');
    exit;
}

require_once(__DIR__ . '/../../usuario/models/AccesoBD_class.php');
$bd = new AccesoBD_Usuario();

$centroId = $_SESSION['user']['centro'];
$centroData = $bd->obtenerCentroById($centroId);

if (is_array($centroData)) {
    $nombreCentro = $centroData['nombre'] ?? 'Desconocido';
} else {
    $nombreCentro = $centroData ?? 'Desconocido';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rankings - LHizki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            padding: 20px;
            padding-bottom: 100px;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 50%, rgba(102, 126, 234, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(118, 75, 162, 0.3) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* Navbar Desktop */
        .navbar-desktop {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            margin-bottom: 30px;
            padding: 15px 25px;
            position: relative;
            z-index: 10;
        }

        .navbar-desktop .container-fluid {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 2rem;
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-menu {
            display: flex;
            gap: 15px;
            align-items: center;
            list-style: none;
            margin: 0;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 15px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover {
            background: rgba(250, 139, 255, 0.15);
            color: #FA8BFF;
            transform: translateY(-2px);
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            color: white;
            box-shadow: 0 6px 20px rgba(250, 139, 255, 0.4);
        }

        /* Barra de navegación inferior móvil */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            padding: 12px 0;
            z-index: 1000;
        }

        .mobile-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 10px 18px;
            text-decoration: none;
            color: #666;
            transition: all 0.3s ease;
            border-radius: 15px;
            min-width: 70px;
        }

        .mobile-nav-item i {
            font-size: 1.6rem;
            transition: all 0.3s ease;
        }

        .mobile-nav-item span {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .mobile-nav-item.active {
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(250, 139, 255, 0.3);
        }

        .mobile-nav-item.active i {
            transform: scale(1.15);
        }

        .mobile-nav-item:hover {
            background: rgba(250, 139, 255, 0.15);
            color: #FA8BFF;
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
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        .category-btn {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            padding: 15px 30px;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1rem;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(250, 139, 255, 0.4);
        }

        .category-btn i {
            font-size: 1.3rem;
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

        .ranking-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .ranking-table thead th {
            background: linear-gradient(135deg, #FA8BFF 0%, #2BD2FF 100%);
            color: white;
            padding: 15px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ranking-table thead th:first-child {
            border-radius: 10px 0 0 10px;
        }

        .ranking-table thead th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .ranking-table tbody tr {
            background: white;
            transition: all 0.3s ease;
        }

        .ranking-table tbody tr:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .ranking-table tbody td {
            padding: 18px 20px;
            border: none;
            color: #333;
            font-weight: 500;
        }

        .ranking-table tbody tr td:first-child {
            border-radius: 10px 0 0 10px;
            font-weight: 600;
        }

        .ranking-table tbody tr td:last-child {
            border-radius: 0 10px 10px 0;
        }

        /* Medallas para top 3 */
        .ranking-table tbody tr:nth-child(1) td:first-child {
            background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
            color: white;
            position: relative;
        }

        .ranking-table tbody tr:nth-child(1) td:first-child::before {
            content: '🥇';
            margin-right: 10px;
            font-size: 1.3rem;
        }

        .ranking-table tbody tr:nth-child(2) td:first-child {
            background: linear-gradient(135deg, #C0C0C0 0%, #A8A8A8 100%);
            color: white;
        }

        .ranking-table tbody tr:nth-child(2) td:first-child::before {
            content: '🥈';
            margin-right: 10px;
            font-size: 1.3rem;
        }

        .ranking-table tbody tr:nth-child(3) td:first-child {
            background: linear-gradient(135deg, #CD7F32 0%, #B8860B 100%);
            color: white;
        }

        .ranking-table tbody tr:nth-child(3) td:first-child::before {
            content: '🥉';
            margin-right: 10px;
            font-size: 1.3rem;
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
                flex-direction: column;
            }

            .category-btn {
                width: 100%;
                justify-content: center;
            }

            .ranking-table {
                font-size: 0.9rem;
            }

            .ranking-table thead th,
            .ranking-table tbody td {
                padding: 12px 15px;
            }
        }

        @media (min-width: 769px) {
            .navbar-desktop {
                display: block;
            }

            .mobile-bottom-nav {
                display: none;
            }
        }
    </style>
</head>
<body>
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
                <i class="bi bi-diagram-3-fill"></i>
                <span>Familia Formativa</span>
            </button>
            <button class="category-btn" onclick="cambiarRanking('sectores')" data-category="sectores">
                <i class="bi bi-mortarboard-fill"></i>
                <span>Grado</span>
            </button>
            <button class="category-btn" onclick="cambiarRanking('clases')" data-category="clases">
                <i class="bi bi-people-fill"></i>
                <span>Clases</span>
            </button>
            <button class="category-btn" onclick="cambiarRanking('individual')" data-category="individual">
                <i class="bi bi-person-fill"></i>
                <span>Individual</span>
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
                    echo '<table class="ranking-table">';
                    echo '<thead><tr><th>Familia Formativa</th><th>Puntuación</th></tr></thead>';
                    echo '<tbody>';
                    foreach ($datos as $fila) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($fila['rama']) . '</td>';
                        echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i>' . htmlspecialchars($fila['puntuacionRanking']) . '</span></td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table>';
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
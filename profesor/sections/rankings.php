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
            background: #f5f7fa;
        }

        .rankings-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .rankings-header {
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .rankings-title {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 12px;
        }

        .rankings-title i {
            font-size: 2.5rem;
            color: #667eea;
        }

        .rankings-title h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin: 0;
        }

        .rankings-subtitle {
            color: #718096;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .center-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #edf2f7;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 600;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .center-badge i {
            color: #667eea;
            font-size: 1.2rem;
        }

        .category-tabs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .category-btn {
            background: white;
            border: 2px solid #e2e8f0;
            padding: 18px 24px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            color: #4a5568;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .category-btn i {
            font-size: 1.4rem;
            color: #667eea;
        }

        .category-btn:hover {
            border-color: #667eea;
            background: #f7fafc;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .category-btn.active {
            background: #667eea;
            border-color: #667eea;
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .category-btn.active i {
            color: white;
        }

        .ranking-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .ranking-table-container {
            overflow-x: auto;
        }

        .ranking-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ranking-table thead {
            background: #f7fafc;
        }

        .ranking-table thead th {
            padding: 16px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
        }

        .ranking-table tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }

        .ranking-table tbody tr:hover {
            background: #f8fafc;
        }

        .ranking-table tbody tr:last-child {
            border-bottom: none;
        }

        .ranking-table tbody td {
            padding: 18px 20px;
            color: #2d3748;
            font-weight: 500;
        }

        .ranking-position {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
        }

        .position-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #edf2f7;
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: 700;
        }

        /* Top 3 Styling */
        .ranking-table tbody tr:nth-child(1) .position-number {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #854d0e;
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        }

        .ranking-table tbody tr:nth-child(2) .position-number {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #3f3f46;
            box-shadow: 0 2px 8px rgba(192, 192, 192, 0.3);
        }

        .ranking-table tbody tr:nth-child(3) .position-number {
            background: linear-gradient(135deg, #cd7f32, #e8a87c);
            color: #7c2d12;
            box-shadow: 0 2px 8px rgba(205, 127, 50, 0.3);
        }

        .ranking-table tbody tr:nth-child(1) {
            background: linear-gradient(to right, rgba(255, 215, 0, 0.05), transparent);
        }

        .ranking-table tbody tr:nth-child(2) {
            background: linear-gradient(to right, rgba(192, 192, 192, 0.05), transparent);
        }

        .ranking-table tbody tr:nth-child(3) {
            background: linear-gradient(to right, rgba(205, 127, 50, 0.05), transparent);
        }

        .score-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
        }

        .score-badge i {
            font-size: 1.1rem;
        }

        .loading-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 80px 20px;
            color: #718096;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #e2e8f0;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: #718096;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: #a0aec0;
            font-size: 0.95rem;
        }

        /* Animaciones */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ranking-card {
            animation: fadeIn 0.4s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .rankings-container {
                padding: 20px 15px;
            }

            .rankings-header {
                padding: 20px;
            }

            .rankings-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .rankings-title h1 {
                font-size: 1.5rem;
            }

            .category-tabs {
                grid-template-columns: 1fr;
            }

            .ranking-table thead th,
            .ranking-table tbody td {
                padding: 12px 15px;
                font-size: 0.9rem;
            }

            .score-badge {
                font-size: 0.9rem;
                padding: 6px 12px;
            }
        }
    </style>
</head>
<body>
   
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
            <div class="ranking-table-container">
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
                        echo '<thead><tr><th>Posición</th><th>Familia Formativa</th><th>Puntuación</th></tr></thead>';
                        echo '<tbody>';
                        $posicion = 1;
                        foreach ($datos as $fila) {
                            echo '<tr>';
                            echo '<td><div class="ranking-position"><span class="position-number">' . $posicion . '</span></div></td>';
                            echo '<td>' . htmlspecialchars($fila['rama']) . '</td>';
                            echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i>' . htmlspecialchars($fila['puntuacionRanking']) . '</span></td>';
                            echo '</tr>';
                            $posicion++;
                        }
                        echo '</tbody></table>';
                    }
                    ?>
                </div>
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
                <div class="loading-state">
                    <div class="spinner"></div>
                    <p>Cargando datos...</p>
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
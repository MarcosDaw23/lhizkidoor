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
    <link rel="stylesheet" href="css/profesorfinal.css">
    
</head>
<body>
    
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
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`[data-category="${categoria}"]`).classList.add('active');

            document.getElementById('ranking-table').innerHTML = `
                <div class="loading-state">
                    <div class="spinner"></div>
                    <p>Cargando datos...</p>
                </div>
            `;

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

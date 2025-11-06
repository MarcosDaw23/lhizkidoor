<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo '<div class="empty-state">';
    echo '<i class="bi bi-lock"></i>';
    echo '<h3>Sesión expirada</h3>';
    echo '<p>Por favor, inicia sesión nuevamente.</p>';
    echo '</div>';
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';
$bd = new AccesoBD_Usuario();
$centro = $_SESSION['user']['centro'];
$clase = $_SESSION['user']['clase'];
$sector = $_SESSION['user']['sector'];

$categoria = $_GET['categoria'] ?? 'ramas';

switch ($categoria) {
    case 'ramas':
        $datos = $bd->obtenerRankingRamas($centro);
        
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
                echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionRanking']) . '</span></td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        break;
        
    case 'sectores':
        $datos = $bd->obtenerRankingSectores($sector);
        
        if (empty($datos)) {
            echo '<div class="empty-state">';
            echo '<i class="bi bi-inbox"></i>';
            echo '<h3>No hay datos disponibles</h3>';
            echo '<p>Aún no hay puntuaciones registradas en esta categoría.</p>';
            echo '</div>';
        } else {
            echo '<table class="ranking-table">';
            echo '<thead><tr><th>Grado</th><th>Puntuación</th></tr></thead>';
            echo '<tbody>';
            foreach ($datos as $fila) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila['sector']) . '</td>';
                echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionSector']) . '</span></td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        break;
        
    case 'clases':
        $datos = $bd->obtenerRankingClases($clase);
        
        if (empty($datos)) {
            echo '<div class="empty-state">';
            echo '<i class="bi bi-inbox"></i>';
            echo '<h3>No hay datos disponibles</h3>';
            echo '<p>Aún no hay puntuaciones registradas en esta categoría.</p>';
            echo '</div>';
        } else {
            echo '<table class="ranking-table">';
            echo '<thead><tr><th>Clase</th><th>Puntuación</th></tr></thead>';
            echo '<tbody>';
            foreach ($datos as $fila) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila['clase']) . '</td>';
                echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionClase']) . '</span></td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        break;
        
    case 'individual':
        $datos = $bd->obtenerRankingClaseIndividual($centro);
        
        if (empty($datos)) {
            echo '<div class="empty-state">';
            echo '<i class="bi bi-inbox"></i>';
            echo '<h3>No hay datos disponibles</h3>';
            echo '<p>Aún no hay puntuaciones registradas en esta categoría.</p>';
            echo '</div>';
        } else {
            echo '<table class="ranking-table">';
            echo '<thead><tr><th>Nombre</th><th>Clase</th><th>Puntuación</th></tr></thead>';
            echo '<tbody>';
            foreach ($datos as $fila) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fila['usuario']) . '</td>';
                echo '<td>' . htmlspecialchars($fila['clase']) . '</td>';
                echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionIndividual']) . '</span></td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        break;
        
    default:
        echo '<div class="empty-state">';
        echo '<i class="bi bi-exclamation-triangle"></i>';
        echo '<h3>Categoría no válida</h3>';
        echo '<p>La categoría solicitada no existe.</p>';
        echo '</div>';
        break;
}
?>

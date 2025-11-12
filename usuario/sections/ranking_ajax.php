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

require_once "../models/AccesoBD_class.php";
$bd = new AccesoBD_Usuario();
$centro = $_SESSION['user']['centro'];
$clase = $_SESSION['user']['clase'];
$sector = $_SESSION['user']['sector'];
$rama = $bd->obtenerIdRamaPorSector($sector);

//Por si acaso actualizarmos los rankings antes de mostrar nada
$bd->actualizarRankingClase($centro, $clase);
$bd->actualizarRankingSectores($centro, $sector);
$bd->actualizarRanking($centro, $rama);

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
            echo '<div class="ranking-list">';
            $position = 1;
            foreach ($datos as $fila) {
                echo '<div class="ranking-item">';
                echo '<div class="ranking-position">' . $position . '</div>';
                echo '<div class="ranking-info">';
                echo '<div class="ranking-name">' . htmlspecialchars($fila['sector']) . '</div>';
                echo '<div class="ranking-subtitle">Grado</div>';
                echo '</div>';
                echo '<span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionSector']) . '</span>';
                echo '</div>';
                $position++;
            }
            echo '</div>';
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
            echo '<div class="ranking-list">';
            $position = 1;
            foreach ($datos as $fila) {
                echo '<div class="ranking-item">';
                echo '<div class="ranking-position">' . $position . '</div>';
                echo '<div class="ranking-info">';
                echo '<div class="ranking-name">' . htmlspecialchars($fila['clase']) . '</div>';
                echo '<div class="ranking-subtitle">Clase</div>';
                echo '</div>';
                echo '<span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionClase']) . '</span>';
                echo '</div>';
                $position++;
            }
            echo '</div>';
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
            echo '<div class="ranking-list">';
            $position = 1;
            foreach ($datos as $fila) {
                echo '<div class="ranking-item">';
                echo '<div class="ranking-position">' . $position . '</div>';
                echo '<div class="ranking-info">';
                echo '<div class="ranking-name">' . htmlspecialchars($fila['usuario']) . '</div>';
                echo '<div class="ranking-subtitle">' . htmlspecialchars($fila['clase']) . '</div>';
                echo '</div>';
                echo '<span class="score-badge"><i class="bi bi-star-fill"></i> ' . htmlspecialchars($fila['puntuacionIndividual']) . '</span>';
                echo '</div>';
                $position++;
            }
            echo '</div>';
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

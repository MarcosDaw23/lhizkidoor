<?php
session_start();
if (!isset($_SESSION['user'])) exit;

require_once(__DIR__ . '../models/AccesoBD_class.php');
$bd = new AccesoBD_Usuario();
$centro = $_SESSION['user']['centro'];
$clase = $_SESSION['user']['clase'];
$sector = $_SESSION['user']['sector'];

$categoria = $_GET['categoria'] ?? 'ramas';

function renderTabla($datos, $columnas, $categoria) {
    if (empty($datos)) {
        echo '<div class="empty-state">';
        echo '<i class="bi bi-inbox"></i>';
        echo '<h3>No hay datos disponibles</h3>';
        echo '<p>Aún no hay puntuaciones registradas en esta categoría.</p>';
        echo '</div>';
        return;
    }

    echo '<table class="ranking-table">';
    echo '<thead><tr>';
    foreach ($columnas as $col) echo "<th>$col</th>";
    echo '</tr></thead><tbody>';

    foreach ($datos as $i => $fila) {
        echo '<tr>';
        foreach ($fila as $key => $valor) {
            // Si es puntuación, aplica badge
            if (stripos($key, 'puntuacion') !== false) {
                echo '<td><span class="score-badge"><i class="bi bi-star-fill"></i>' . htmlspecialchars($valor) . '</span></td>';
            } else {
                echo '<td>' . htmlspecialchars($valor) . '</td>';
            }
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
}

switch ($categoria) {
    case 'ramas':
        $datos = $bd->obtenerRankingRamas($centro);
        renderTabla($datos, ['Familia Formativa', 'Puntuación'], $categoria);
        break;
    case 'sectores':
        $datos = $bd->obtenerRankingSectores($sector);
        renderTabla($datos, ['Grado', 'Puntuación'], $categoria);
        break;
    case 'clases':
        $datos = $bd->obtenerRankingClases($clase);
        renderTabla($datos, ['Clase', 'Puntuación'], $categoria);
        break;
    case 'individual':
        $datos = $bd->obtenerRankingClaseIndividual($centro);
        renderTabla($datos, ['Nombre', 'Clase', 'Puntuación'], $categoria);
        break;
}

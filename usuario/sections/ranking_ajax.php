<?php
session_start();

// opcional: proteger si no hay usuario en sesión
if (!isset($_SESSION['user'])) {
    // redirigir al login o manejar el caso
    header('Location: /login.php');
    exit;
}

require_once "../models/AccesoBD_class.php";
$bd = new AccesoBD_Usuario();
$centro = $_SESSION['user']['centro'];
$clase = $_SESSION['user']['clase'];
$sector = $_SESSION['user']['sector'];

$categoria = $_GET['categoria'] ?? 'ramas';

function renderTabla($datos, $columnas) {
    echo "<table><thead><tr>";
    foreach ($columnas as $col) {
        echo "<th>$col</th>";
    }
    echo "</tr></thead><tbody>";
    foreach ($datos as $fila) {
        echo "<tr>";
        foreach ($fila as $valor) {
            echo "<td>$valor</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}

switch ($categoria) {
    case 'ramas':
        $datos = $bd->obtenerRankingRamas($centro);
        renderTabla($datos, ['Familia Formativa', 'Puntuación']);
        break;
    case 'sectores':
        $datos = $bd->obtenerRankingSectores($sector);
        renderTabla($datos, ['Grado', 'Puntuación']);
        break;
    case 'clases':
        $datos = $bd->obtenerRankingClases($clase);
        renderTabla($datos, ['Clase', 'Puntuación']);
        break;
    case 'individual':
        $datos = $bd->obtenerRankingClaseIndividual($centro);
        renderTabla($datos, ['Nombre', 'Clase', 'Puntuación']);
        break;
}
?>

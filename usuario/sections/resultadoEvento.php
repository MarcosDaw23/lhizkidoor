<?php 
require_once __DIR__ . './models/AccesoBD.class.php';
$id_evento = $_SESSION['evento'];
$id_usuario = $_SESSION['usuario_id'];
$bd = new AccesoBD_class();

$miEstadistica = $bd->obtenerMiEstadistica($id_evento, $id_usuario);

if ($miEstadistica) {
    echo "Puntos: " . $miEstadistica['puntuacion'] . "<br>";
    echo "Aciertos: " . $miEstadistica['aciertos'] . "<br>";
    echo "Fallos: " . $miEstadistica['fallos'];
} else {
    echo "No hay estadísticas para este evento.";
}
?>
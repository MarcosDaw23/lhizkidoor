<?php
require_once '../models/AccesoBD_class.php';

if (isset($_POST['sector_id'])) {
    $sector_id = intval($_POST['sector_id']);
    $bd = new AccesoBD();

    $sql = "SELECT id, nombre FROM clases WHERE sector = $sector_id ORDER BY nombre";
    $res = $bd->lanzarSQL($sql);

    if ($res && mysqli_num_rows($res) > 0) {
        echo '<option value="">Selecciona una clase</option>';
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['nombre']).'</option>';
        }
    } else {
        echo '<option value="">No hay clases disponibles</option>';
    }

    $bd->cerrarConexion();
} else {
    echo '<option value="">Error, no se pudo obtener sector_id</option>';
}
?>

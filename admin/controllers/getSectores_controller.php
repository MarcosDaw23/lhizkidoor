<?php
require_once '../models/AccesoBD_class.php';

if (isset($_POST['centro_id'])) {
    $centro_id = intval($_POST['centro_id']);
    $bd = new AccesoBD();

    $sql = "SELECT s.id, s.nombre 
            FROM centro_sector cs
            INNER JOIN sectores s ON cs.sector = s.id
            WHERE cs.centro = $centro_id
            ORDER BY s.nombre";

    $res = $bd->lanzarSQL($sql);

    if ($res && mysqli_num_rows($res) > 0) {
        echo '<option value="">Selecciona un sector</option>';
        while ($row = mysqli_fetch_assoc($res)) {
            echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['nombre']).'</option>';
        }
    } else {
        echo '<option value="">No hay sectores disponibles</option>';
    }

    $bd->cerrarConexion();
} else {
    echo '<option value="">Error, no se pudo obtener centro_id</option>';
}
?>

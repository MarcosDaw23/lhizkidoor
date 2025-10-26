<?php
require_once __DIR__ . '/../../core/database.php';

class AccesoBD_Usuario {

    //hay codigo repetido de los metodos de los registros proque no salia con las conexiones, ya sea por error de conexion o de codigo (cambiarlo a futuro)
    public function obtenerRamaPorSector($sectorId) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT r.id, r.nombre 
                FROM ramas r
                INNER JOIN sectores s ON s.rama = r.id
                WHERE s.id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $sectorId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        $db->cerrarConexion();
        return $result['nombre'] ?? null; 
    }

    public function obtenerDiccionarioCompleto() {
        $db = new AccesoBD();
        $sql = "SELECT id, rama, cast, eusk1, eusk2, eusk3, definicion 
                FROM diccionario
                ORDER BY rama ASC, cast ASC";
        $result = $db->lanzarSQL($sql);

        $diccionario = [];
        while ($fila = mysqli_fetch_assoc($result)) {
            $diccionario[] = $fila;
        }

        $db->cerrarConexion();
        return $diccionario;
    }

    public function obtenerDiccionarioPorRama($ramaId, $busqueda = '') {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT id, rama, cast, eusk1, eusk2, eusk3, definicion
                FROM diccionario
                WHERE rama = ?";

        if (!empty($busqueda)) {
            $sql .= " AND cast LIKE ?";
        }

        $sql .= " ORDER BY cast ASC";
        $stmt = $conn->prepare($sql);

        if (!empty($busqueda)) {
            $like = "%$busqueda%";
            $stmt->bind_param("is", $ramaId, $like);
        } else {
            $stmt->bind_param("i", $ramaId);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $diccionario = [];
        while ($fila = $result->fetch_assoc()) {
            $diccionario[] = $fila;
        }

        $db->cerrarConexion();

        if (empty($diccionario)) {
            error_log("fallo numero ns cuantos de la bd, problemas en la rama $ramaId (busqueda='$busqueda')");
        }

        return $diccionario;
    }

    public function obtenerTodasLasRamas() {
        $db = new AccesoBD();
        $sql = "SELECT id, nombre FROM ramas ORDER BY nombre ASC";
        $result = $db->lanzarSQL($sql);

        $ramas = [];
        while ($fila = mysqli_fetch_assoc($result)) {
            $ramas[] = $fila;
        }

        $db->cerrarConexion();
        return $ramas;
    }

}
?>

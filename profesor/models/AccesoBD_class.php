<?php
require_once __DIR__ . '/../../core/database.php';

class AccesoBD_Profesor {

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

     public function obtenerTodasLasRamas() {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT id, nombre FROM ramas ORDER BY nombre ASC";
        $result = $conn->query($sql);
        $ramas = [];
        while ($fila = $result->fetch_assoc()) {
            $ramas[] = $fila;
        }

        $db->cerrarConexion();
        return $ramas;
    }

    public function insertarPalabraDiccionario($rama, $cast, $eusk1, $eusk2, $eusk3, $ondo, $definicion) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "INSERT INTO diccionario (rama, cast, eusk1, eusk2, eusk3, ondo, definicion)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issssds", $rama, $cast, $eusk1, $eusk2, $eusk3, $ondo, $definicion);
        $ok = $stmt->execute();

        $db->cerrarConexion();
        return $ok;
    }

    public function insertarPalabraGlosario($rama, $cast, $eusk, $definicion) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "INSERT INTO glosario (rama, cast, eusk, definicion) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $rama, $cast, $eusk, $definicion);
        $ok = $stmt->execute();

        $db->cerrarConexion();
        return $ok;
    }


}
?>

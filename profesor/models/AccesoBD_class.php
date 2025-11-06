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

    // ✅ Obtener estadísticas de partidas
public function obtenerEstadisticasPartidas() {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "
        SELECT 
            u.id AS user_id,
            CONCAT(u.nombre, ' ', u.apellido) AS jugador,
            COUNT(pu.id) AS partidas_jugadas,
            SUM(pu.puntuacion) AS total_puntos,
            AVG(pu.puntuacion) AS promedio_puntos,
            MAX(pu.fechaJugada) AS ultima_partida
        FROM partida_user pu
        INNER JOIN user u ON pu.user_id = u.id
        GROUP BY u.id
        ORDER BY total_puntos DESC
    ";

    $result = $conn->query($sql);
    $estadisticas = [];

    while ($fila = $result->fetch_assoc()) {
        $estadisticas[] = $fila;
    }

    $db->cerrarConexion();
    return $estadisticas;
}

// ✅ Crear un evento
public function crearEvento($nombre, $profesor_id, $num_preguntas, $clases, $sectores) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "INSERT INTO eventos (user, nombre, num_preguntas, fechaInicio, fechaFin, fechaCreacion)
            VALUES (?, ?, ?, NOW(), NULL, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $profesor_id, $nombre, $num_preguntas);
    $ok = $stmt->execute();

    if (!$ok) return false;
    $evento_id = $conn->insert_id;

    // Guardar destinatarios (clases / sectores)
    $sql_rel = "INSERT INTO evento_destinatarios (evento_id, clase_id, sector_id) VALUES (?, ?, ?)";
    $stmt_rel = $conn->prepare($sql_rel);

    foreach ($clases as $clase_id) {
        $sector_id = null;
        $stmt_rel->bind_param("iii", $evento_id, $clase_id, $sector_id);
        $stmt_rel->execute();
    }

    foreach ($sectores as $sector_id) {
        $clase_id = null;
        $stmt_rel->bind_param("iii", $evento_id, $clase_id, $sector_id);
        $stmt_rel->execute();
    }

    $db->cerrarConexion();
    return $evento_id;
}

// ✅ Obtener correos de los usuarios implicados
public function obtenerCorreosUsuariosEvento($clases, $sectores) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $condiciones = [];
    if (!empty($clases)) {
        $claseIn = implode(",", array_map('intval', $clases));
        $condiciones[] = "clase IN ($claseIn)";
    }
    if (!empty($sectores)) {
        $sectorIn = implode(",", array_map('intval', $sectores));
        $condiciones[] = "sector IN ($sectorIn)";
    }

    $where = $condiciones ? "WHERE " . implode(" OR ", $condiciones) : "";
    $sql = "SELECT mail FROM user $where";
    $result = $conn->query($sql);

    $correos = [];
    while ($row = $result->fetch_assoc()) {
        $correos[] = $row;
    }

    $db->cerrarConexion();
    return $correos;
}

// ✅ Obtener todas las clases y sectores
public function obtenerTodasLasClases() {
    $db = new AccesoBD();
    $conn = $db->conexion;
    $result = $conn->query("SELECT id, nombre FROM clases ORDER BY nombre ASC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

public function obtenerTodosLosSectores() {
    $db = new AccesoBD();
    $conn = $db->conexion;
    $result = $conn->query("SELECT id, nombre FROM sectores ORDER BY nombre ASC");
    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}

// 🔹 Obtener los usuarios que pertenecen a las clases o sectores seleccionados
public function obtenerUsuariosEvento($clases = [], $sectores = []) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    // Si no hay filtros, devolver array vacío
    if (empty($clases) && empty($sectores)) {
        return [];
    }

    // Crear condiciones dinámicas
    $condiciones = [];
    if (!empty($clases)) {
        // Escapar cada valor para evitar inyecciones
        $claseIds = implode(',', array_map('intval', $clases));
        $condiciones[] = "clase IN ($claseIds)";
    }

    if (!empty($sectores)) {
        $sectorIds = implode(',', array_map('intval', $sectores));
        $condiciones[] = "sector IN ($sectorIds)";
    }

    // Combinar las condiciones con OR (solo uno de los dos filtros estará activo)
    $where = implode(' OR ', $condiciones);

    // Consulta final
    $sql = "SELECT id, nombre, apellido, mail 
            FROM user 
            WHERE rol = 3 AND ($where)"; // rol=3 → alumnos

    $result = $conn->query($sql);

    $usuarios = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }

    $db->cerrarConexion();
    return $usuarios;
}

}
?>

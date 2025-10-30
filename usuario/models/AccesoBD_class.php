<?php
require_once __DIR__ . '/../../core/database.php';

class AccesoBD_Usuario {

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

  
    public function haJugadoEstaSemana($usuarioId) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $semanaActual = date('W');
        $sql = "SELECT COUNT(*) AS total
                FROM partida_user pu
                INNER JOIN partidas p ON pu.partida_id = p.id
                WHERE pu.user_id = ? AND p.semana = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $usuarioId, $semanaActual);
        $stmt->execute();

        $resultado = $stmt->get_result()->fetch_assoc();
        $db->cerrarConexion();

        return ($resultado['total'] ?? 0) > 0;
    }

   public function registrarPartidaSemanal() {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $semanaActual = date('W');

    $sqlPartida = "SELECT id FROM partidas WHERE semana = ?";
    $stmt = $conn->prepare($sqlPartida);
    $stmt->bind_param("i", $semanaActual);
    $stmt->execute();
    $partida = $stmt->get_result()->fetch_assoc();

    if (!$partida) {
        $sqlInsert = "INSERT INTO partidas (semana, fechaJugada) VALUES (?, NOW())";
        $stmt2 = $conn->prepare($sqlInsert);
        $stmt2->bind_param("i", $semanaActual);
        $stmt2->execute();
        $partidaId = $conn->insert_id;
    } else {
        $partidaId = $partida['id'];
    }

    $db->cerrarConexion();
    return $partidaId;
}



    public function obtenerPalabraAleatoria() {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT id, cast, eusk1, eusk2, eusk3, ondo, definicion
                FROM diccionario
                ORDER BY RAND()
                LIMIT 1";
        $result = $conn->query($sql);
        $palabra = $result->fetch_assoc();

        $db->cerrarConexion();
        return $palabra;
    }

    public function obtenerPreguntas() {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT id, cast, eusk1, eusk2, eusk3, ondo, definicion
                FROM diccionario
                ORDER BY RAND()
                LIMIT 10";
        $result = $conn->query($sql);

        $preguntas = [];
        while ($row = $result->fetch_assoc()) {
            $preguntas[] = $row;
        }

        $db->cerrarConexion();
        return $preguntas;
    }

public function actualizarPuntuacionClase($usuarioId, $puntuacionFinal) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sqlSector = "SELECT sector FROM user WHERE id = ?";
    $stmt = $conn->prepare($sqlSector);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $sectorId = $res['sector'];

    if (!$sectorId) {
        $db->cerrarConexion();
        return;
    }

    $sqlUpdateSector = "UPDATE sectores
                        SET puntuacionTotal = puntuacionTotal + ?
                        WHERE id = ?";
    $stmt2 = $conn->prepare($sqlUpdateSector);
    $stmt2->bind_param("ii", $puntuacionFinal, $sectorId);
    $stmt2->execute();

    $sqlRama = "SELECT rama FROM sectores WHERE id = ?";
    $stmt3 = $conn->prepare($sqlRama);
    $stmt3->bind_param("i", $sectorId);
    $stmt3->execute();
    $resRama = $stmt3->get_result()->fetch_assoc();
    $ramaId = $resRama['rama'];

    if ($ramaId) {
        $sqlUpdateRama = "UPDATE ramas
                          SET puntuacionRamas = puntuacionRamas + ?
                          WHERE id = ?";
        $stmt4 = $conn->prepare($sqlUpdateRama);
        $stmt4->bind_param("ii", $puntuacionFinal, $ramaId);
        $stmt4->execute();
    }

    $db->cerrarConexion();
}


    public function obtenerPartidaSemanaActual() {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $semana = date('W');
        $sql = "SELECT id FROM partidas WHERE semana = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $semana);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();

        if (!$res) {
            $sqlInsert = "INSERT INTO partidas (semana, fechaJugada) VALUES (?, NOW())";
            $stmt2 = $conn->prepare($sqlInsert);
            $stmt2->bind_param("i", $semana);
            $stmt2->execute();
            $res['id'] = $conn->insert_id;
        }

        $db->cerrarConexion();
        return $res['id'];
    }

    
   public function registrarPartidaUsuario($usuarioId, $partidaId, $puntuacion) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sqlCheck = "SELECT id FROM partida_user WHERE user_id = ? AND partida_id = ?";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bind_param("ii", $usuarioId, $partidaId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res) {
        $sqlUpdate = "UPDATE partida_user SET puntuacion = ?, fechaJugada = NOW() WHERE id = ?";
        $stmt2 = $conn->prepare($sqlUpdate);
        $stmt2->bind_param("ii", $puntuacion, $res['id']);
        $stmt2->execute();
    } else {
        $sqlInsert = "INSERT INTO partida_user (user_id, partida_id, puntuacion, fechaJugada)
                      VALUES (?, ?, ?, NOW())";
        $stmt3 = $conn->prepare($sqlInsert);
        $stmt3->bind_param("iii", $usuarioId, $partidaId, $puntuacion);
        $stmt3->execute();
    }

    $sqlUpdateUser = "UPDATE user 
                      SET puntuacionIndividual = puntuacionIndividual + ? 
                      WHERE id = ?";
    $stmtUser = $conn->prepare($sqlUpdateUser);
    $stmtUser->bind_param("ii", $puntuacion, $usuarioId);
    $stmtUser->execute();

    $db->cerrarConexion();
}

public function obtenerPreguntasPorRamaUsuario($usuarioId) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sqlRama = "SELECT s.rama 
                FROM user u
                INNER JOIN sectores s ON u.sector = s.id
                WHERE u.id = ?";
    $stmt = $conn->prepare($sqlRama);
    $stmt->bind_param("i", $usuarioId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $ramaId = $res['rama'] ?? null;

    if (!$ramaId) {
        $db->cerrarConexion();
        return []; // No se encontró rama
    }

    $sqlPreguntas = "SELECT id, cast, eusk1, eusk2, eusk3, ondo, definicion
                     FROM diccionario
                     WHERE rama = ?
                     ORDER BY RAND()
                     LIMIT 10";
    $stmt2 = $conn->prepare($sqlPreguntas);
    $stmt2->bind_param("i", $ramaId);
    $stmt2->execute();
    $result = $stmt2->get_result();

    $preguntas = [];
    while ($row = $result->fetch_assoc()) {
        $preguntas[] = $row;
    }

    $db->cerrarConexion();
    return $preguntas;
}

}
?>

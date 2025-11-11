<?php
require_once __DIR__ . '/../../core/database.php';

class AccesoBD_Usuario {

    public function actualizarPuntuacionClase($usuarioId, $puntuacionFinal) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        // Obtener el sector del usuario
        $sqlClase = "SELECT sector FROM user WHERE id = ?";
        $stmt = $conn->prepare($sqlClase);
        $stmt->bind_param("i", $usuarioId);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        $claseId = $res['sector'];

        $db->cerrarConexion();
    }

     public function insertarRanking($id_evento, $alumno, $puntuacion, $fallos, $aciertos) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "INSERT INTO evento_ranking (id_evento, alumno, puntuacion, fallos, aciertos)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isiii", $id_evento, $alumno, $puntuacion, $fallos, $aciertos);
        $stmt->execute();

        $insertId = $conn->insert_id;

        $stmt->close();
        $db->cerrarConexion();
        return $insertId;
    }

    // 3️⃣ Obtener todos los registros de un evento específico
    public function obtenerPorEvento($id_evento) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        // Limitar a los 5 primeros resultados
        $sql = "SELECT * FROM evento_ranking WHERE id_evento = ? ORDER BY puntuacion DESC LIMIT 5";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_evento);
        $stmt->execute();

        $result = $stmt->get_result();
        $registros = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $db->cerrarConexion();
        return $registros;
    }

    public function obtenerMiEstadistica($id_evento, $id_usuario) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    // 1. Obtener aciertos, fallos y puntuación
    $sql = "SELECT aciertos, fallos, puntuacion 
            FROM evento_ranking 
            WHERE id_evento = ? AND id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_evento, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        $db->cerrarConexion();
        return null; // Usuario no encontrado en el evento
    }

    // 3. Retornar todos los datos
    return [
        'aciertos' => $row['aciertos'],
        'fallos' => $row['fallos'],
        'puntuacion' => $row['puntuacion'],
    ];
}

public function obtenerEventoPorId($eventoId) {
    $db = new AccesoBD();
    $conn = $db->conexion;
    $stmt = $conn->prepare("SELECT * FROM eventos WHERE id = ?");
    $stmt->bind_param("i", $eventoId);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $db->cerrarConexion();
    return $res;
    }

    public function obtenerPreguntasEvento($cantidad) {
        $db = new AccesoBD();
        $conn = $db->conexion;
        $sql = "SELECT * FROM diccionario ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cantidad);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $db->cerrarConexion();
        return $result;
    }

    public function obtenerCentroById($centroId) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "SELECT nombre 
            FROM centro
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $centroId); // ✅ corregido
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    $db->cerrarConexion();

    // ✅ devuelve solo el nombre, o 'Desconocido' si no existe
    return $result['nombre'] ?? 'Desconocido';
    }


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

    public function obtenerGlosarioPorRama($ramaId, $busqueda = '') {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "SELECT id, rama, cast, eusk, definicion
                FROM glosario
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

        $glosario = [];
        while ($fila = $result->fetch_assoc()) {
            $glosario[] = $fila;
        }

        $db->cerrarConexion();
        return $glosario;
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
        $sqlInsert = "INSERT INTO partidas (semana, fechaInicio) VALUES (?, NOW())";
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

public function obtenerRankingRamas($centro){
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "SELECT r.nombre AS rama, ranking.puntuacionRanking
            FROM ranking
            INNER JOIN ramas r ON ranking.rama = r.id
            WHERE ranking.centro = ?
            ORDER BY ranking.puntuacionRanking DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $centro);
    $stmt->execute();
    $result = $stmt->get_result();

    $ranking = [];
    while ($fila = $result->fetch_assoc()) {
        $ranking[] = $fila;
    }

    $db->cerrarConexion();
    return $ranking;
}

public function actualizarRanking($centro, $rama) {
    $db = new AccesoBD();
    $conn = $db->conexion;
    $sql = "UPDATE ranking
            SET puntuacionRanking = (
            SELECT SUM(u.puntuacionIndividual)
            FROM user u
                LEFT JOIN clases c ON u.clase = c.id
                LEFT JOIN centro_sector cs ON cs.sector = c.sector
                LEFT JOIN sectores s ON cs.sector = s.id
                LEFT JOIN ramas r ON s.rama = r.id
                WHERE cs.centro = ?
                AND r.id = ?)
            WHERE centro = ?
            AND rama = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $centro, $rama, $centro, $rama);
    $stmt->execute();

    $db->cerrarConexion();
}

public function obtenerRankingClaseIndividual($centro){
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "SELECT u.nombre AS usuario, c.nombre AS clase, u.puntuacionIndividual
            FROM user u
            INNER JOIN clases c ON u.clase = c.id
            WHERE u.centro = ?
            ORDER BY u.puntuacionIndividual DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $centro);
    $stmt->execute();
    $result = $stmt->get_result();

    $ranking = [];
    while ($fila = $result->fetch_assoc()) {
        $ranking[] = $fila;
    }

    $db->cerrarConexion();
    return $ranking;
}

public function obtenerRankingClases($clase){
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "SELECT c.nombre AS clase, ranking_clases.puntuacionClase
            FROM ranking_clases
            INNER JOIN clases c ON ranking_clases.clase = c.id
            WHERE ranking_clases.clase = ?
            ORDER BY ranking_clases.puntuacionClase DESC;";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clase);
    $stmt->execute();
    $result = $stmt->get_result();

    $ranking = [];
    while ($fila = $result->fetch_assoc()) {
        $ranking[] = $fila;
    }

    $db->cerrarConexion();
    return $ranking;
}

public function actualizarRankingClase($centro, $clase) {
    $db = new AccesoBD();
    $conn = $db->conexion;
    $sql = "UPDATE ranking_clases
            SET puntuacionClase = (
            SELECT SUM(u.puntuacionIndividual)
            FROM user u
                LEFT JOIN clases c ON u.clase = c.id
                WHERE c.id = ?)
            WHERE centro = ?
            AND clase = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $clase, $centro, $clase);
    $stmt->execute();

    $db->cerrarConexion();
}

public function obtenerRankingSectores($sector){
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "SELECT s.nombre AS sector, ranking_sectores.puntuacionSector
            FROM ranking_sectores
            INNER JOIN sectores s ON ranking_sectores.sector = s.id
            WHERE ranking_sectores.sector = ?
            ORDER BY ranking_sectores.puntuacionSector DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sector);
    $stmt->execute();
    $result = $stmt->get_result();

    $ranking = [];
    while ($fila = $result->fetch_assoc()) {
        $ranking[] = $fila;
    }

    $db->cerrarConexion();
    return $ranking;
}

public function actualizarRankingSectores($centro, $sector) {
    $db = new AccesoBD();
    $conn = $db->conexion;
    $sql = "UPDATE ranking_sectores
            SET puntuacionSector = (
            SELECT SUM(u.puntuacionIndividual)
            FROM user u
                LEFT JOIN clases c ON u.clase = c.id
                LEFT JOIN centro_sector cs ON cs.sector = c.sector
                WHERE cs.sector = ?
            WHERE centro = ?
            AND sector = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $sector, $centro, $sector);
    $stmt->execute();

    $db->cerrarConexion();
}


}
?>
<?php
require_once __DIR__ . '/../../core/database.php';

class AccesoBD_Usuario {

    // Obtener la rama a partir del sector
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

    // Diccionario completo
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

    // Diccionario por rama
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

    /**
     * Verifica si el usuario ya ha jugado esta semana.
     */
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

    /**
     * Registra una nueva partida semanal (si no existe).
     */
    public function registrarPartidaSemanal($usuarioId) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $semanaActual = date('W');

        // Buscar o crear la partida de esta semana
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

        // Registrar al usuario en la partida semanal
        $sqlPU = "INSERT INTO partida_user (user_id, partida_id, fechaJugada)
                  VALUES (?, ?, NOW())";
        $stmt3 = $conn->prepare($sqlPU);
        $stmt3->bind_param("ii", $usuarioId, $partidaId);
        $stmt3->execute();

        $db->cerrarConexion();
    }

    /**
     * Devuelve una palabra aleatoria.
     */
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

    /**
     * Actualiza la puntuación total del sector del usuario.
     */
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

        // Sumar la nueva puntuación al sector
        $sqlUpdate = "UPDATE sectores
                      SET puntuacionTotal = puntuacionTotal + ?
                      WHERE id = ?";
        $stmt2 = $conn->prepare($sqlUpdate);
        $stmt2->bind_param("ii", $puntuacionFinal, $claseId);
        $stmt2->execute();

        $db->cerrarConexion();
    }

    /**
     * Obtiene la partida actual de la semana.
     */
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

    /**
     * Registra el resultado del usuario en una partida concreta.
     */
    public function registrarPartidaUsuario($usuarioId, $partidaId, $puntuacion) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $sql = "INSERT INTO partida_user (user_id, partida_id, puntuacion, fechaJugada)
                VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $usuarioId, $partidaId, $puntuacion);
        $stmt->execute();

        // Actualizar puntuación total del usuario
        $sqlUpdate = "UPDATE user 
                      SET puntuacionIndividual = puntuacionIndividual + ? 
                      WHERE id = ?";
        $stmt2 = $conn->prepare($sqlUpdate);
        $stmt2->bind_param("ii", $puntuacion, $usuarioId);
        $stmt2->execute();

        $db->cerrarConexion();
    }
}
?>

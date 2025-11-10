<?php
require_once __DIR__ . '/../../core/database.php';
require_once __DIR__ . '/../../core/Modelos/Palabra_class.php';

class AccesoBD_Profesor {

    public function obtenerUsuarios($nombre = '', $centro = '', $sector = '', $clase = '', $rol = '', $ordenFecha = 'DESC') {
        $db = new AccesoBD();
        $nombre = mysqli_real_escape_string($db->conexion, $nombre);
        $condiciones = [];

        if ($nombre !== '') $condiciones[] = "u.nombre LIKE '%$nombre%'";
        if ($centro !== '') $condiciones[] = "u.centro = " . intval($centro);
        if ($sector !== '') $condiciones[] = "u.sector = " . intval($sector);
        if ($clase !== '')  $condiciones[] = "u.clase = " . intval($clase);
        if ($rol !== '')    $condiciones[] = "u.rol = " . intval($rol);

        $where = count($condiciones) > 0 ? "WHERE " . implode(" AND ", $condiciones) : "";
        $ordenFecha = strtoupper($ordenFecha) === 'ASC' ? 'ASC' : 'DESC'; 
        $sql = "SELECT 
                    u.id, u.nombre, u.apellido, u.mail, u.rol,
                    c.nombre AS centro, s.nombre AS sector, cl.nombre AS clase, u.fechaConfirmacion
                FROM user u
                LEFT JOIN centro c ON u.centro = c.id
                LEFT JOIN sectores s ON u.sector = s.id
                LEFT JOIN clases cl ON u.clase = cl.id
                $where
                ORDER BY u.fechaConfirmacion $ordenFecha";

        $res = $db->lanzarSQL($sql);
        $usuarios = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $usuarios[] = $fila;
        }
        $db->cerrarConexion();
        return $usuarios;
    }

    public function obtenerCentros() {
        $db = new AccesoBD();
        $sql = "SELECT id, nombre FROM centro ORDER BY nombre ASC";
        $res = $db->lanzarSQL($sql);
        $centros = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $centros[] = $fila;
        }
        $db->cerrarConexion();
        return $centros;
    }

    public function obtenerEstadisticasJugadores($clase) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    // Total de alumnos en la clase
    $sql_total = "SELECT COUNT(*) AS total_usuarios 
                  FROM user 
                  WHERE rol = 3 AND clase = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("i", $clase);
    $stmt_total->execute();
    $res_total = $stmt_total->get_result();
    $total = (int)$res_total->fetch_assoc()['total_usuarios'];

    // Alumnos que han jugado al menos una partida en esa clase
    $sql_jugados = "SELECT COUNT(DISTINCT pu.user_id) AS usuarios_jugaron
                    FROM partida_user pu
                    JOIN user u ON pu.user_id = u.id
                    WHERE u.rol = 3 AND u.clase = ?";
    $stmt_jugados = $conn->prepare($sql_jugados);
    $stmt_jugados->bind_param("i", $clase);
    $stmt_jugados->execute();
    $res_jugados = $stmt_jugados->get_result();
    $jugados = (int)$res_jugados->fetch_assoc()['usuarios_jugaron'];

    // Nunca negativo
    $no_jugados = max(0, $total - $jugados);

    $db->cerrarConexion();

    return [
        'total' => $total,
        'jugados' => $jugados,
        'no_jugados' => $no_jugados
    ];
}

    public function obtenerSectores() {
        $db = new AccesoBD();
        $sql = "SELECT id, nombre FROM sectores ORDER BY nombre ASC";
        $res = $db->lanzarSQL($sql);
        $sectores = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $sectores[] = $fila;
        }
        $db->cerrarConexion();
        return $sectores;
    }

    public function obtenerClases() {
        $db = new AccesoBD();
        $sql = "SELECT id, nombre FROM clases ORDER BY nombre ASC";
        $res = $db->lanzarSQL($sql);
        $clases = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $clases[] = $fila;
        }
        $db->cerrarConexion();
        return $clases;
    }

    public function obtenerUsuarioPorId($id) {
        $db = new AccesoBD();
        $sql = "SELECT * FROM user WHERE id = " . intval($id);
        $res = $db->lanzarSQL($sql);
        $usuario = mysqli_fetch_assoc($res);
        $db->cerrarConexion();
        return $usuario;
    }

    public function actualizarUsuario($datos) {
        $db = new AccesoBD();
        $id = intval($datos['id']);
        $nombre = mysqli_real_escape_string($db->conexion, $datos['nombre']);
        $apellido = mysqli_real_escape_string($db->conexion, $datos['apellido']);
        $mail = mysqli_real_escape_string($db->conexion, $datos['mail']);
        $rol = intval($datos['rol']);
        $centro = intval($datos['centro']);
        $sector = intval($datos['sector']);
        $clase = intval($datos['clase']);

        $sql = "UPDATE user SET 
            nombre = '$nombre', 
            apellido = '$apellido', 
            mail = '$mail', 
            rol = $rol,
            centro = $centro,
            sector = $sector,
            clase = $clase
        WHERE id = $id";
        $res = $db->lanzarSQL($sql);
        $db->cerrarConexion();
        return $res;
    }

    public function insertarNuevaPalabra($rama, $cast, $eusk, $definicion) {
        $db = new AccesoBD();

        $sql = "INSERT INTO glosario (rama, cast, eusk, definicion) 
        VALUES ('$rama', '$cast', '$eusk', '$definicion')";

        $res = $db->lanzarSQL($sql);
        $db->cerrarConexion();

        return $res;
    }

    public function borrarUsuario($id) {
        $db = new AccesoBD();
        $sql = "DELETE FROM user WHERE id = " . intval($id);
        $res = $db->lanzarSQL($sql);
        $db->cerrarConexion();
        return $res;
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

    public function registrarProfesor(User $user) {
        $db = new AccesoBD();
        $conn = $db->conexion;
        $nombre   = mysqli_real_escape_string($conn, $user->getNombre());
        $apellido = mysqli_real_escape_string($conn, $user->getApellido());
        $email    = mysqli_real_escape_string($conn, $user->getEmail());
        $password = mysqli_real_escape_string($conn, $user->getPassword());
        $centro   = $user->getCentro() ? intval($user->getCentro()) : "NULL";
        $sector   = $user->getSector() ? intval($user->getSector()) : "NULL";
        $clase    = $user->getClase() ? intval($user->getClase()) : "NULL";
        $rol      = 2; 
        $password = md5($password);

        $sqlCheck = "SELECT id FROM user WHERE mail = '$email'";
        $result = $db->lanzarSQL($sqlCheck);

        if ($result && mysqli_num_rows($result) > 0) {
            $db->cerrarConexion();
            return false; 
        }

        $fechaConfirmacion = date('Y-m-d H:i:s');
        $sqlInsert = "
            INSERT INTO user (rol, nombre, apellido, mail, password, centro, sector, clase, token, fechaConfirmacion)
            VALUES ($rol, '$nombre', '$apellido', '$email', '$password', 
                    $centro, $sector, $clase, NULL, '$fechaConfirmacion')
        ";

        $resultado = $db->lanzarSQL($sqlInsert);
        $db->cerrarConexion();
        return $resultado ? true : false;
    }

    public function crearEvento($nombre, $profesor_id, $num_preguntas, $clases) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $sql = "INSERT INTO eventos (user, nombre, num_preguntas, fechaInicio, fechaFin, fechaCreacion)
            VALUES (?, ?, ?, NOW(), NULL, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $profesor_id, $nombre, $num_preguntas);
    $ok = $stmt->execute();

    if (!$ok) return false;
    $evento_id = $conn->insert_id;

    // Guardar destinatarios (clases)
    $sql_rel = "INSERT INTO evento_destinatarios (evento_id, clase_id) VALUES (?, ?)";
    $stmt_rel = $conn->prepare($sql_rel);

    foreach ($clases as $clase_id) {
        $sector_id = null;
        $stmt_rel->bind_param("ii", $evento_id, $clase_id);
        $stmt_rel->execute();
    }

    $db->cerrarConexion();
    return $evento_id;
}

    public function obtenerCorreosUsuariosEvento($clases) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    $condiciones = [];
    if (!empty($clases)) {
        $claseIn = implode(",", array_map('intval', $clases));
        $condiciones[] = "clase IN ($claseIn)";
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

    public function obtenerUsuariosEvento($clases = []) {
    $db = new AccesoBD();
    $conn = $db->conexion;

    // Si no hay filtros, devolver array vacío
    if (empty($clases)) {
        return [];
    }

    // Crear condiciones dinámicas
    $condiciones = [];
    if (!empty($clases)) {
        // Escapar cada valor para evitar inyecciones
        $claseIds = implode(',', array_map('intval', $clases));
        $condiciones[] = "clase IN ($claseIds)";
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

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

}
?>

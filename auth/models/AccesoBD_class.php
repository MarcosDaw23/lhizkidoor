<?php
require_once __DIR__ . '/../../core/database.php';

class AccesoBD_Auth {

    public static function obtenerCentros() {
        $db = new AccesoBD();
        $sql = "SELECT id, nombre FROM centro ORDER BY nombre";
        $res = $db->lanzarSQL($sql);
        $centros = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $centros[] = $fila;
        }
        $db->cerrarConexion();
        return $centros;
    }

    public static function obtenerSectoresPorCentro($centro_id) {
        $db = new AccesoBD();
        $centro_id = intval($centro_id);
        $sql = "SELECT s.id, s.nombre
                FROM centro_sector cs
                INNER JOIN sectores s ON cs.sector = s.id
                WHERE cs.centro = $centro_id
                ORDER BY s.nombre";
        $res = $db->lanzarSQL($sql);
        $sectores = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $sectores[] = $fila;
        }
        $db->cerrarConexion();
        return $sectores;
    }

    public static function obtenerClasesPorSector($sector_id) {
        $db = new AccesoBD();
        $sector_id = intval($sector_id);
        $sql = "SELECT id, nombre FROM clases WHERE sector = $sector_id ORDER BY nombre";
        $res = $db->lanzarSQL($sql);
        $clases = [];
        while ($fila = mysqli_fetch_assoc($res)) {
            $clases[] = $fila;
        }
        $db->cerrarConexion();
        return $clases;
    }

    public function registrarUsuario(User $user) {
        $db = new AccesoBD();
        $conn = $db->conexion;

        $nombre   = mysqli_real_escape_string($conn, $user->getNombre());
        $apellido = mysqli_real_escape_string($conn, $user->getApellido());
        $email    = mysqli_real_escape_string($conn, $user->getEmail());
        $password = mysqli_real_escape_string($conn, $user->getPassword());
        $centro   = intval($user->getCentro());
        $sector   = intval($user->getSector());
        $clase    = intval($user->getClase());
        $rol      = 3; 

        $password = md5($password);

        $sqlCheck = "SELECT id FROM user WHERE mail = '$email'";
        $result = $db->lanzarSQL($sqlCheck);

        if ($result && mysqli_num_rows($result) > 0) {
            $db->cerrarConexion();
            return false; 
        }

        $token = md5(uniqid(rand(), true));
        $sqlInsert = "INSERT INTO user (rol, nombre, apellido, mail, password, centro, sector, clase, token, fechaConfirmacion)
                    VALUES ($rol, '$nombre', '$apellido', '$email', '$password', $centro, $sector, $clase, '$token', NULL)";
        $db->lanzarSQL($sqlInsert);
        $db->cerrarConexion();
        return $token;
    }

    public function confirmarUsuarioPorToken($token) {
        $db = new AccesoBD();
        $conn = $db->conexion;
        $token = mysqli_real_escape_string($conn, $token);

        $sqlSelect = "SELECT id FROM user WHERE token = '$token' LIMIT 1";
        $result = $db->lanzarSQL($sqlSelect);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id = intval($row['id']);
            $sqlUpdate = "UPDATE user SET fechaConfirmacion = NOW(), token = NULL WHERE id = $id";
            $db->lanzarSQL($sqlUpdate);
            $db->cerrarConexion();
            return true;
        } else {
            $db->cerrarConexion();
            return false;
        }
    }

    public function loginUsuario($email, $password) {
        $db = new AccesoBD();
        $conn = $db->conexion;
        $email = mysqli_real_escape_string($conn, trim($email));
        $password = md5(trim($password)); 
        $sql = "SELECT * FROM user WHERE mail = '$email' LIMIT 1";
        $result = $db->lanzarSQL($sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_assoc($result);

            if (empty($userData['fechaConfirmacion'])) {
                $db->cerrarConexion();
                return ['error' => 'no_confirmada'];
            }
            if ($userData['password'] === $password) {
                $db->cerrarConexion();
                return $userData; 
            } else {
                $db->cerrarConexion();
                return ['error' => 'incorrecta'];
            }
        } else {
            $db->cerrarConexion();
            return ['error' => 'no_existe'];
        }
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];          
        session_destroy();       

        header("Location: /1semestre/lhizkidoor/auth/index.php?section=login");
        exit;
    }

}
?>

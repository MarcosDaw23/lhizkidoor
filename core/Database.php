<?php
class AccesoBD {
    const RUTA = "localhost";
    const BD = "lhizki"; 
    const USER = "root";
    const PASS = "1234";
    public $conexion;

    function __construct() {
        $this->conectar();
    }

    function conectar() {
        $this->conexion = mysqli_connect(self::RUTA, self::USER, self::PASS, self::BD)
            or die("Error al establecer la conexión con la BD");
        mysqli_set_charset($this->conexion, "utf8mb4");
    }

    function cerrarConexion() {
        mysqli_close($this->conexion);
    }

    function lanzarSQL($SQL) {
        $tipoSQL = strtoupper(substr(trim($SQL), 0, 6));
        $res = mysqli_query($this->conexion, $SQL);
        if (!$res) {
            die("Error SQL: " . mysqli_error($this->conexion));
        }
        return $res;
    }
}
?>

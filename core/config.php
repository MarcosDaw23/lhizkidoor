<?php
/**
 * Clase de configuración global del proyecto LHizkiDoor
 * Centraliza rutas, URLs y configuraciones comunes.
 */

class Config
{
    /** @var string URL base del proyecto */
    public static string $BASE_URL;

    /** @var string Directorios base */
    public static string $PATH_AUTH;
    public static string $PATH_USUARIO;
    public static string $PATH_ADMIN;
    public static string $PATH_ASSETS;
    public static string $PATH_IMG;
    public static string $PATH_CSS;
    public static string $PATH_JS;

    /** @var string Controladores */
    public static string $CTRL_AUTH;
    public static string $CTRL_USUARIO;
    public static string $CTRL_ADMIN;

    /** @var string Rutas útiles */
    public static string $LOGOUT;
    public static string $LOGIN;
    public static string $HOME_USUARIO;
    public static string $RANKING;
    public static string $JUEGOS;

    /**
     * Inicializa todas las rutas dinámicamente según el entorno.
     * Esto evita el uso de const + $_SERVER (que lanza error).
     */
    public static function init(): void
    {
        // Detecta el dominio actual y construye la ruta base completa
        self::$BASE_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/lhizkidoor-aritz/';

        /** Carpetas principales */
        self::$PATH_AUTH    = self::$BASE_URL . 'auth/';
        self::$PATH_USUARIO = self::$BASE_URL . 'usuario/';
        self::$PATH_ADMIN   = self::$BASE_URL . 'admin/';
        self::$PATH_ASSETS  = self::$BASE_URL . 'assets/';
        self::$PATH_IMG     = self::$BASE_URL . 'usuario/img/';
        self::$PATH_CSS     = self::$BASE_URL . 'usuario/css/';
        self::$PATH_JS      = self::$BASE_URL . 'usuario/js/';

        /** Controladores */
        self::$CTRL_AUTH    = self::$PATH_AUTH . 'controllers/';
        self::$CTRL_USUARIO = self::$PATH_USUARIO . 'controllers/';
        self::$CTRL_ADMIN   = self::$PATH_ADMIN . 'controllers/';

        /** Rutas útiles */
        self::$LOGOUT       = self::$CTRL_AUTH . 'logout_controller.php';
        self::$LOGIN        = self::$PATH_AUTH . 'index.php?section=login';
        self::$HOME_USUARIO = self::$PATH_USUARIO . 'index.php';
        self::$RANKING      = self::$CTRL_USUARIO . 'obtenerRanking_controller.php';
        self::$JUEGOS       = self::$CTRL_USUARIO . 'partidaSemanal_controller.php?action=jugar';
    }
}

// Ejecutar la inicialización automáticamente al cargar
Config::init();
?>

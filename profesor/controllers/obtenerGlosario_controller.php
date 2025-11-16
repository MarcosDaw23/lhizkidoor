<?php
require_once __DIR__ . '/../../usuario/models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}
//hay que cAMBIAR la obtencion de daros d ela tabla diccionario a la tabla glosario
$usuario = $_SESSION['user'];
$sectorId = $usuario['sector'];

$bd = new AccesoBD_Usuario();
$ramas = $bd->obtenerTodasLasRamas();
$ramaUsuarioNombre = $bd->obtenerRamaPorSector($sectorId);

//pa sacr el id de la rama con el que hacer las consultas
$ramaUsuarioId = null;
foreach ($ramas as $r) {
    if ($r['nombre'] === $ramaUsuarioNombre) {
        $ramaUsuarioId = $r['id'];
        break;
    }
}

$ramaSeleccionada = $_GET['rama'] ?? $ramaUsuarioId;
$busqueda = $_GET['buscar'] ?? ''; // nuevo filtro por palabra

if (!empty($ramaSeleccionada)) {
    $glosario = $bd->obtenerGlosarioPorRama($ramaSeleccionada, $busqueda);
} else {
    $glosario = $bd->obtenerGlosarioCompleto($busqueda);
}

$_SESSION['glosario'] = $glosario;
$_SESSION['ramas'] = $ramas;
$_SESSION['ramaSeleccionada'] = $ramaSeleccionada;
$_SESSION['busqueda'] = $busqueda;

header("Location: ../index.php?section=VerGlosario");
exit;
?>

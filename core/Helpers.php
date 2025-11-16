<?php
// Incluir el sistema de idiomas
require_once __DIR__ . '/idiomas.php';

// Función helper para traducir textos según el idioma del usuario
function traducir($clave, $idioma = null) {
    return obtenerTraduccion($clave, $idioma);
}

// Función para obtener el idioma actual del usuario
function idiomaActual() {
    return $_SESSION['user']['idioma'] ?? 'español';
}

// Función para cambiar el idioma del usuario (actualiza sesión y BD)
function cambiarIdioma($nuevoIdioma) {
    if (in_array($nuevoIdioma, ['español', 'euskera'])) {
        $_SESSION['user']['idioma'] = $nuevoIdioma;
        // Aquí se podría actualizar también en la BD si se desea
        return true;
    }
    return false;
}
?>


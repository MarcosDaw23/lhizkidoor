<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

if (isset($_POST['agregar_glosario'])) {
    $rama = $_POST['rama'] ?? null;
    $cast = trim($_POST['cast'] ?? '');
    $eusk = trim($_POST['eusk'] ?? '');
    $definicion = trim($_POST['definicion'] ?? '');

    if ($rama && $cast && $eusk && $definicion) {
        $db = new AccesoBD_Profesor();
        $resultado = $db->insertarNuevaPalabra($rama, $cast, $eusk, $definicion);

        if ($resultado) {
            $_SESSION['mensaje'] = "Palabra añadida correctamente al glosario.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Ocurrió un error al guardar la palabra en el glosario.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos requeridos.";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    header("Location: ../index.php?section=SumarPalabras");
    exit;
}
?>

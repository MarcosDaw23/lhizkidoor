<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

if (isset($_POST['agregar_palabra'])) {
    $rama = $_POST['rama'] ?? null;
    $cast = trim($_POST['cast'] ?? '');
    $eusk1 = trim($_POST['eusk1'] ?? '');
    $eusk2 = trim($_POST['eusk2'] ?? '');
    $eusk3 = trim($_POST['eusk3'] ?? '');
    $ondo = $_POST['ondo'] ?? null;
    $definicion = trim($_POST['definicion'] ?? '');

    if ($rama && $cast && $definicion) {
        $db = new AccesoBD_Profesor();
        $resultado = $db->insertarPalabraDiccionario($rama, $cast, $eusk1, $eusk2, $eusk3, $ondo, $definicion);

        if ($resultado) {
            $_SESSION['mensaje'] = "Palabra añadida correctamente al diccionario.";
            $_SESSION['tipo_mensaje'] = "success";
        } else {
            $_SESSION['mensaje'] = "Ocurrió un error al guardar la palabra en el diccionario.";
            $_SESSION['tipo_mensaje'] = "danger";
        }
    } else {
        $_SESSION['mensaje'] = "Por favor, completa todos los campos obligatorios.";
        $_SESSION['tipo_mensaje'] = "warning";
    }

    header("Location: ../index.php?section=SumarPalabras");
    exit;
}
?>

<?php
session_start();
require_once "../models/AccesoBD_class.php";

$bd = new AccesoBD_Profesor();
$id_evento = $_SESSION['evento'];

$bd->eliminarPorEvento($id_evento);

header("Location: ../index.php");
exit;

<?php
require_once __DIR__ . '/../../core/Config.php';
require_once __DIR__ . '/../models/AccesoBD_class.php';
session_start();

$bd = new AccesoBD_Auth();
$bd->logout();
exit;
?>

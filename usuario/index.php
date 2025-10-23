<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'usuario') {
    header("Location: ../auth/");
    exit;
}
?>

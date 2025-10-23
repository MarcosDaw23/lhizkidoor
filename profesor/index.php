<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'profesor') {
    header("Location: ../auth/");
    exit;
}
?>
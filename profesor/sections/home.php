<?php

if (!isset($_SESSION['user'])) {
    header("Location: /lhizkidoor/auth/index.php?section=login");
    exit;
}

$usuario = $_SESSION['user'];


require_once __DIR__ . '/../models/AccesoBD_class.php';

$usuarioModel = new AccesoBD_Profesor();
$usuarios = $usuarioModel->obtenerUsuarios();
$totalUsuarios = count($usuarios);

$sectoresModel = new AccesoBD_Profesor();
$sectores = $sectoresModel->obtenerSectores();
$totalSectores= count($sectores);


$clasesModel = new AccesoBD_Profesor();
$clases = $clasesModel->obtenerClases();
$totalClases = count($clases);


?>

<link rel="stylesheet" href="css/profesorfinal.css">




<div class="dashboard-grid">
  <div class="stat-card">
    <div class="stat-card-header">
      <div>
        <div class="stat-value"><?php echo $totalUsuarios; ?></div>
        <div class="stat-label">Total Alumnos</div> 
      </div>
      <div class="stat-icon blue">
        <i class="bi bi-people"></i>
      </div>
    </div>
  </div>

  <div class="stat-card">

    <div class="stat-card-header">
      <div>
        <div class="stat-value"><?php echo $totalSectores; ?></div>
        <div class="stat-label">Sectores</div>
      </div>
      <div class="stat-icon green">
        <i class="bi bi-person-video"></i>
      </div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div>
        <div class="stat-value"><?php echo $totalClases; ?></div>
        <div class="stat-label">Clases</div>
      </div>
      <div class="stat-icon orange">
        <i class="bi bi-mortarboard"></i>
      </div>
    </div>
  </div>
</div>


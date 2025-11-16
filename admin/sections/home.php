<?php

if (!isset($_SESSION['user'])) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

$usuario = $_SESSION['user'];


require_once __DIR__ . '/../models/AccesoBD_class.php';
$usuarioModel = new AccesoBD_Admin();
$todosLosUsuarios = $usuarioModel->obtenerUsuarios();
$totalUsuarios = count($todosLosUsuarios);

// Obtener solo los 6 usuarios más recientes
$usuarios = array_slice($todosLosUsuarios, 0, 6);


$totalProfesores = 0;
foreach ($todosLosUsuarios as $u) {
    if (isset($u['rol']) && $u['rol'] == 2) { 
        $totalProfesores++;
    }
}


$centrosModel = new AccesoBD_Admin();
$centros = $centrosModel->obtenerCentros();
$totalCentros = count($centros);
?>

<link rel="stylesheet" href="css/adminfinal.css">




<div class="dashboard-grid">
  <div class="stat-card">
    <div class="stat-card-header">
      <div>
        <div class="stat-value"><?php echo $totalUsuarios; ?></div>
        <div class="stat-label">Total Usuarios</div> 
      </div>
      <div class="stat-icon blue">
        <i class="bi bi-people"></i>
      </div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div>
        <div class="stat-value"><?php echo $totalProfesores; ?></div>
        <div class="stat-label">Profesores</div>
      </div>
      <div class="stat-icon green">
        <i class="bi bi-person-video"></i>
      </div>
    </div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div>
        <div class="stat-value"><?php echo $totalCentros; ?></div>
        <div class="stat-label">Centros</div>
      </div>
      <div class="stat-icon orange">
        <i class="bi bi-mortarboard"></i>
      </div>
    </div>
  </div>
</div>




<div class="content-grid">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Usuarios Recientes</h3>
      <a href="./controllers/obtenerUsuarios_controller.php" class="card-action">
        Ver todos <i class="bi bi-arrow-right"></i>
      </a>
    </div>
    <table class="users-table">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Rol</th>
          <th>Centro</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td>
              <div class="user-name-cell">
                <div class="user-avatar-table">
                  <?= strtoupper(substr($u['nombre'], 0, 1)) ?>
                </div>
                <div class="user-info">
                  <div class="user-full-name">
                    <?= htmlspecialchars($u['nombre']) ?> <?= htmlspecialchars($u['apellido']) ?>
                  </div>
                  <div class="user-email"><?= htmlspecialchars($u['mail']) ?></div>
                </div>
              </div>
            </td>
            <td>
              <?php 
                $rolClass = '';
                $rolText = '';
                switch ($u['rol']) {
                  case 1: 
                    $rolClass = 'admin'; 
                    $rolText = 'Administrador'; 
                    break;
                  case 2: 
                    $rolClass = 'profesor'; 
                    $rolText = 'Profesor'; 
                    break;
                  default: 
                    $rolClass = 'usuario'; 
                    $rolText = 'Usuario';
                }
              ?>
              <span class="role-badge <?= $rolClass ?>"><?= $rolText ?></span>
            </td>
            <td><?= htmlspecialchars($u['centro'] ?? '-') ?></td>

           
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  
</div>

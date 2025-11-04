<?php
spl_autoload_register(function ($class) {
    $path = __DIR__ . "/model/{$class}.class.php";
    if (file_exists($path)) {
        require_once $path;
    }
});
//los index son todos los de mikel
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /lhizkidoor-juan/auth/index.php?section=login");
    exit;
}

$usuario = $_SESSION['user'];
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LHizki - Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css?v=2.0">
    
  </head>

  <body>
    <div class="admin-layout">
      <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
          <img src="../auth/img/LHizki_Logo.png" alt="LHizki Logo" class="sidebar-logo">
          <a href="./index.php" class="sidebar-brand">LHizki</a>
        </div>

        <nav class="sidebar-menu">
          <div class="menu-section-title">Principal</div>
          <a href="./index.php" class="menu-item active">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
          </a>

          <div class="menu-section-title">Gestión</div>
          <a href="./controllers/obtenerUsuarios_controller.php" class="menu-item">
            <i class="bi bi-people"></i>
            <span>Glosario</span>
          </a>
          <a href="index.php?section=crearProfesor" class="menu-item">
            <i class="bi bi-person-plus"></i>
            <span>Crear eventos</span>
          </a>
          <a href="./control/obtenerEstadisticas_controller.php" class="menu-item">
            <i class="bi bi-bar-chart"></i>
            <span>Estadísticas</span>
          </a>
        </nav>

        <div class="sidebar-footer">
          <div class="user-info-sidebar">
            <div class="user-avatar">
              <?php echo strtoupper(substr($usuario['nombre'], 0, 1)); ?>
            </div>
            <div class="user-details">
              <div class="user-name"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
              <div class="user-role">Profesor</div>
            </div>
            <a href="index.php?section=perfil" class="settings-icon" title="Configuración">
              <i class="bi bi-gear"></i>
            </a>
          </div>
        </div>
      </aside>

      <div class="main-content">
        <header class="topbar">
          <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebarToggle">
              <i class="bi bi-list"></i>
            </button>
            <h1>Panel de Administración</h1>
          </div>
          <div class="topbar-right">
            <a href="/lhizkidoor-juan/auth/controllers/logout_controller.php" class="logout-btn">
              <i class="bi bi-box-arrow-right"></i>
              <span>Cerrar Sesión</span>
            </a>
          </div>
        </header>

        <!-- Área de Contenido -->
        <main class="content-area">
          <?php 
            $view = "home"; 
            if (isset($_GET['section'])) {
              $view = $_GET['section'];
            }

            include "./sections/$view.php";
          ?>
        </main>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    
      document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
      });
      document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebarToggle');
        
        if (window.innerWidth <= 992 && sidebar && toggle && 
            !sidebar.contains(event.target) && !toggle.contains(event.target)) {
          sidebar.classList.remove('active');
        }
      });
    </script>
  </body>
</html>

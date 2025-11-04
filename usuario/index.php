<?php
spl_autoload_register(function ($class) {
    $path = __DIR__ . "/model/{$class}.class.php";
    if (file_exists($path)) {
        require_once $path;
    }
});

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: /1semestre/lhizkidoor/auth/index.php?section=login");
    exit;
}

$usuario = $_SESSION['user'];
?>

<!doctype html>
<html lang="es" data-bs-theme="auto">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LHizki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
      body {
        padding-top: 70px; /* evita que el navbar tape el contenido */
      }
      .alert {
        position: fixed;
        top: 70px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        max-width: 600px;
        z-index: 2000;
        text-align: center;
        font-size: 1.05rem;
      }
    </style>
  </head>

  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">LHizki</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
         <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 3): ?>
              <li class="nav-item">
                <a class="nav-link btn btn-warning text-blue" href="./controllers/obtenerGlosario_controller.php">Ver glosario</a>
              </li>
               <li class="nav-item">
                <a class="nav-link btn btn-warning text-blue" href="index.php?section=juegos">Juegos</a>
              </li>
               <li class="nav-item">
                <a class="nav-link btn btn-warning text-blue" href="./controllers/obtenerRanking_controller.php">Ranking</a>
              </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user'])){ ?>
            <a href="index.php?s=ajustes" class="btn btn-secondary">
              <i class="bi bi-gear"></i> 
            </a>
            <?php }?>
          </form>
        </div>

        <div class="collapse navbar-collapse" id="navbarCollapse">
        </div>
      </div>
    </nav>

    <?php if (isset($_SESSION['mensaje'])): ?>
      <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
      <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
      ?>
    <?php endif; ?>

    <main class="container mt-4">
      <?php 
        $view = "home"; 
        if (isset($_GET['section'])) {
          $view = $_GET['section'];
        }

        include "./sections/$view.php";
      ?>
    </main>

  </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }
      }, 3000);
    </script>
</html>

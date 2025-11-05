<?php
spl_autoload_register(function ($class) {
    $path = __DIR__ . "/model/{$class}.class.php";
    if (file_exists($path)) {
        require_once $path;
    }
});

session_start();
if (isset($_SESSION['semana_jugada']) && $_SESSION['semana_jugada'] != date('W')) {
    $_SESSION['yaJugo'] = false;
    $_SESSION['semana_jugada'] = date('W'); // actualiza la semana actual, pero solo del usuarfio, tengo que añadir la semana de la bd pa que sea automatizado
}
if (!isset($_SESSION['user'])) {
        header("Location: ../auth/index.php?section=login");
    exit;
}

$usuario = $_SESSION['user'];
$currentPage = $_GET['section'] ?? 'home';
?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LHizki - Panel de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-bottom: 80px; /* Espacio para la barra inferior móvil */
        }

        /* Navbar Desktop */
        .navbar-desktop {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-desktop .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-menu {
            display: flex;
            gap: 10px;
            align-items: center;
            list-style: none;
            margin: 0;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            color: #333;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link-custom:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 16px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 50px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .user-name {
            font-weight: 600;
            color: #333;
        }

        /* Botón de logout */
        .btn-logout {
            padding: 10px 20px;
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-logout:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        /* Barra de navegación inferior móvil */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.15);
            padding: 12px 0;
            z-index: 1000;
        }

        .mobile-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 8px 16px;
            text-decoration: none;
            color: #666;
            transition: all 0.3s ease;
            border-radius: 12px;
            min-width: 70px;
        }

        .mobile-nav-item i {
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .mobile-nav-item span {
            font-size: 0.75rem;
            font-weight: 600;
        }

        .mobile-nav-item.active {
            color: #667eea;
        }

        .mobile-nav-item.active i {
            transform: scale(1.2);
        }

        .mobile-nav-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        /* Contenedor principal */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Alertas */
        .alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 600px;
            z-index: 2000;
            text-align: center;
            font-size: 1rem;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-desktop {
                display: none;
            }

            .mobile-bottom-nav {
                display: block;
            }

            body {
                padding-bottom: 80px;
            }

            .main-container {
                padding: 20px 15px;
            }
        }

        @media (min-width: 769px) {
            .navbar-desktop {
                display: block;
            }

            .mobile-bottom-nav {
                display: none;
            }

            body {
                padding-bottom: 0;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Desktop -->
    <nav class="navbar-desktop">
        <div class="container">
            <a href="./index.php" class="navbar-brand">
                <i class="bi bi-mortarboard-fill"></i>
                LHizki
            </a>

            <ul class="navbar-menu">
                <li>
                    <a href="./index.php" class="nav-link-custom <?= $currentPage === 'home' ? 'active' : '' ?>">
                        <i class="bi bi-house-fill"></i>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="./index.php?section=juegos" class="nav-link-custom <?= $currentPage === 'juegos' ? 'active' : '' ?>">
                        <i class="bi bi-controller"></i>
                        <span>Juegos</span>
                    </a>
                </li>
                <li>
                    <a href="./sections/rankings.php" class="nav-link-custom">
                        <i class="bi bi-trophy-fill"></i>
                        <span>Rankings</span>
                    </a>
                </li>
                <li>
                    <a href="./controllers/obtenerGlosario_controller.php" class="nav-link-custom">
                        <i class="bi bi-journal-text"></i>
                        <span>Glosario</span>
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <div class="user-info">
                    <div class="user-avatar">
                        <?= strtoupper(substr($usuario['nombre'], 0, 1)) ?>
                    </div>
                    <span class="user-name"><?= htmlspecialchars($usuario['nombre']) ?></span>
                </div>
                <a href="../auth/controllers/logout_controller.php" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Salir</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Alertas -->
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

    <!-- Contenido Principal -->
    <main class="main-container">
        <?php 
            $view = "home"; 
            if (isset($_GET['section'])) {
                $view = $_GET['section'];
            }

            include "./sections/$view.php";
        ?>
    </main>

    <!-- Barra de navegación inferior móvil -->
    <nav class="mobile-bottom-nav">
        <div class="mobile-nav-items">
            <a href="./index.php" class="mobile-nav-item <?= $currentPage === 'home' ? 'active' : '' ?>">
                <i class="bi bi-house-fill"></i>
                <span>Inicio</span>
            </a>
            <a href="./index.php?section=juegos" class="mobile-nav-item <?= $currentPage === 'juegos' ? 'active' : '' ?>">
                <i class="bi bi-controller"></i>
                <span>Juegos</span>
            </a>
            <a href="./sections/rankings.php" class="mobile-nav-item">
                <i class="bi bi-trophy-fill"></i>
                <span>Ranking</span>
            </a>
            <a href="./controllers/obtenerGlosario_controller.php" class="mobile-nav-item">
                <i class="bi bi-journal-text"></i>
                <span>Glosario</span>
            </a>
            <a href="../auth/controllers/logout_controller.php" class="mobile-nav-item">
                <i class="bi bi-box-arrow-right"></i>
                <span>Salir</span>
            </a>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto cerrar alertas después de 3 segundos
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 3000);
    </script>
</body>
</html>

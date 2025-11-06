<?php
spl_autoload_register(function ($class) {
    $path = __DIR__ . "/model/{$class}.class.php";
    if (file_exists($path)) {
        require_once $path;
    }
});

session_start();
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
            background: linear-gradient(135deg, #667eea 20%, #764ba2 60%);
            min-height: 100vh;
            padding-bottom: 100px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 10% 20%, rgba(255, 107, 107, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(79, 172, 254, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(250, 139, 255, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(255, 255, 255, 0.03) 2px, rgba(255, 255, 255, 0.03) 4px);
            pointer-events: none;
            z-index: 0;
        }

        /* Navbar Desktop */
        .navbar-desktop {
            background: rgba(15, 15, 35, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            padding: 20px 0;
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
            font-weight: 900;
            font-size: 2.2rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 50%, #00f2fe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            filter: drop-shadow(0 0 20px rgba(255, 107, 107, 0.4));
        }

        .navbar-brand i {
            font-size: 2rem;
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .navbar-menu {
            display: flex;
            gap: 12px;
            align-items: center;
            list-style: none;
            margin: 0;
        }

        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .nav-link-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.2) 0%, rgba(79, 172, 254, 0.2) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .nav-link-custom:hover {
            color: white;
            transform: translateY(-2px);
        }

        .nav-link-custom:hover::before {
            opacity: 1;
        }

        .nav-link-custom.active {
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .nav-link-custom i {
            font-size: 1.2rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            backdrop-filter: blur(10px);
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 0 20px rgba(255, 107, 107, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .user-name {
            font-weight: 600;
            color: white;
            font-size: 0.95rem;
        }

        /* Botón de logout */
        .btn-logout {
            padding: 10px 20px;
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.3);
            color: #ff6b6b;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-logout::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-logout:hover {
            color: white;
            border-color: transparent;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.5);
        }

        .btn-logout:hover::before {
            left: 0;
        }

        /* Barra de navegación inferior móvil */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(15, 15, 35, 0.95);
            backdrop-filter: blur(20px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 -8px 32px rgba(0, 0, 0, 0.5);
            padding: 15px 0;
            z-index: 1000;
        }

        .mobile-nav-items {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 600px;
            margin: 0 auto;
            padding: 0 10px;
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
            border-radius: 12px;
            min-width: 60px;
            position: relative;
        }

        .mobile-nav-item i {
            font-size: 1.5rem;
            transition: all 0.3s ease;
        }

        .mobile-nav-item span {
            font-size: 0.7rem;
            font-weight: 600;
        }

        .mobile-nav-item.active {
            color: white;
        }

        .mobile-nav-item.active::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 3px;
            background: linear-gradient(90deg, #ff6b6b 0%, #4facfe 100%);
            border-radius: 3px 3px 0 0;
            box-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
        }

        .mobile-nav-item.active i {
            transform: scale(1.15);
            color: #4facfe;
        }

        .mobile-nav-item:hover {
            color: white;
        }

        /* Contenedor principal */
        .main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 30px;
            position: relative;
            z-index: 1;
        }

        /* Alertas */
        .alert {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 500px;
            z-index: 2000;
            text-align: center;
            font-size: 0.95rem;
            padding: 16px 24px;
            border-radius: 12px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideDown 0.4s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
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
                padding-bottom: 110px;
            }

            .main-container {
                padding: 30px 20px;
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
                    <a href="./index.php?section=rankings" class="nav-link-custom">
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

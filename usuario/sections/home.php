<?php
if (!isset($_SESSION['usuario'])) {
    header("Location: /1semestre/lhizkidoor/auth/index.php?section=login");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

  <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?> 👋</h1>
    <p>Tu rol es: <?php echo $usuario['rol']; ?></p>
    <a href="/1semestre/lhizkidoor/auth/controllers/logout_controller.php" class="btn btn-danger">
    Cerrar sesión
    </a>
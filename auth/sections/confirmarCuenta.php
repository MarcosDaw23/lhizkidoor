<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$mensaje = '';
$tipo = '';
$mostrarBoton = false;

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $bd = new AccesoBD_Auth();

    if ($bd->confirmarUsuarioPorToken($token)) {
        $mensaje = "Tu cuenta ha sido confirmada correctamente";
        $tipo = "success";
        $mostrarBoton = true;
    } else {
        $mensaje = "El enlace no vale o ya fue utilizado";
        $tipo = "danger";
    }
} 
?>

<style>
  .confirmation-container {
    width: 100%;
    max-width: 500px;
    position: relative;
    z-index: 1;
    background: rgba(255, 255, 255, 0.95);
    padding: 50px 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
    text-align: center;
  }

  .confirmation-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 25px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
  }

  .icon-success {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    animation: scaleIn 0.5s ease-out;
  }

  .icon-danger {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
    animation: shake 0.5s ease-out;
  }

  .icon-warning {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #fff;
    animation: scaleIn 0.5s ease-out;
  }

  @keyframes scaleIn {
    0% {
      transform: scale(0);
      opacity: 0;
    }
    50% {
      transform: scale(1.1);
    }
    100% {
      transform: scale(1);
      opacity: 1;
    }
  }

  @keyframes shake {
    0%, 100% {
      transform: translateX(0);
    }
    10%, 30%, 50%, 70%, 90% {
      transform: translateX(-5px);
    }
    20%, 40%, 60%, 80% {
      transform: translateX(5px);
    }
  }

  .confirmation-container h2 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 20px;
  }

  .confirmation-message {
    font-size: 1.05rem;
    color: #666;
    margin-bottom: 35px;
    line-height: 1.6;
  }

  .btn-confirm {
    width: 100%;
    padding: 14px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
  }

  .btn-confirm:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    color: white;
  }

  .btn-secondary-confirm {
    width: 100%;
    padding: 14px;
    background: #f8f9fa;
    color: #333;
    border: 2px solid #e0e0e0;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
  }

  .btn-secondary-confirm:hover {
    background: #e0e0e0;
    border-color: #ccc;
    color: #333;
  }
</style>

<div class="confirmation-container">
  <?php if ($tipo === 'success'): ?>
    <div class="confirmation-icon icon-success">
      <i class="bi bi-check-circle-fill"></i>
    </div>
  <?php elseif ($tipo === 'danger'): ?>
    <div class="confirmation-icon icon-danger">
      <i class="bi bi-x-circle-fill"></i>
    </div>
  <?php else: ?>
    <div class="confirmation-icon icon-warning">
      <i class="bi bi-exclamation-triangle-fill"></i>
    </div>
  <?php endif; ?>

  <h2>Confirmación de cuenta</h2>
  
  <p class="confirmation-message">
    <?php echo htmlspecialchars($mensaje); ?>
  </p>

  <?php if ($mostrarBoton): ?>
    <a href="index.php?section=login" class="btn-confirm">
      <i class="bi bi-box-arrow-in-right"></i>
      <span>Ir al login</span>
    </a>
  <?php else: ?>
    <a href="https://mail.google.com" class="btn-secondary-confirm">
      <i class="bi bi-envelope-exclamation-fill"></i>
      <span>Confirmar correo</span>
    </a>
  <?php endif; ?>
</div>

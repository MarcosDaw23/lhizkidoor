<?php 
spl_autoload_register(function ($class) {
    $path = __DIR__ . "/model/{$class}.class.php";
    if (file_exists($path)) {
        require_once $path;
    }
});

session_start();

// Cargar sistema de traducciones
require_once __DIR__ . '/../core/Helpers.php';
?>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LHizki - Autenticación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        overflow-x: hidden;
      }

      .auth-container {
        min-height: 100vh;
        display: flex;
      }

      /* Lado izquierdo - Features */
      .left-side {
        flex: 1;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px;
        color: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }

      .logo-section {
        margin-bottom: 40px;
      }

      .logo-section h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 15px;
      }

      .logo-section .graduation-icon {
        width: 90px;
        height: 90px;
        background: rgba(255, 255, 255, 0.86);
        padding: 10px;
        border-radius: 12px;
        object-fit: contain;
      }

      .logo-section p {
        font-size: 1.1rem;
        opacity: 0.95;
        font-weight: 400;
      }

      .features-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 40px;
      }

      .feature-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 30px 25px;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.2);
      }

      .feature-card:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-5px);
      }

      .feature-card i {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: block;
      }

      .feature-card h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
      }

      .feature-card p {
        font-size: 0.95rem;
        opacity: 0.9;
        line-height: 1.5;
      }

      /* Lado derecho - Formulario */
      .right-side {
        flex: 1;
        background: linear-gradient(135deg, #a8b5d1 0%, #c8d3e8 50%, #b8c5db 100%);
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
      }

      /* Elementos decorativos de fondo - ondas suaves */
      .right-side::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
          radial-gradient(ellipse 800px 600px at 10% 20%, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
          radial-gradient(ellipse 600px 800px at 90% 80%, rgba(118, 75, 162, 0.12) 0%, transparent 50%),
          radial-gradient(ellipse 500px 500px at 50% 50%, rgba(102, 126, 234, 0.08) 0%, transparent 50%);
        z-index: 0;
        filter: blur(60px);
      }

      .right-side::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 80%;
        height: 150%;
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.4) 0%, rgba(255, 255, 255, 0.1) 50%, transparent 100%);
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        transform: rotate(-15deg);
        z-index: 0;
        opacity: 0.6;
      }

      /* Onda decorativa adicional */
      .right-side .wave-decoration {
        position: absolute;
        bottom: -10%;
        left: -10%;
        width: 120%;
        height: 60%;
        background: linear-gradient(165deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.15) 50%, transparent 100%);
        border-radius: 50% 50% 0 0 / 40% 40% 0 0;
        z-index: 0;
        opacity: 0.7;
      }

      .form-container {
        width: 100%;
        max-width: 450px;
        position: relative;
        z-index: 1;
        background: rgba(255, 255, 255, 0.95);
        padding: 30px 35px;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
      }

      .form-container h2 {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 5px;
      }

      .form-container .subtitle {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 20px;
      }

      .form-group {
        margin-bottom: 16px;
      }

      .form-group label {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
      }

      .form-group label i {
        font-size: 1rem;
        color: #667eea;
      }

      .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
      }

      .form-control:focus {
        outline: none;
        border-color: #667eea;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      }

      .password-input-wrapper {
        position: relative;
      }

      .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.2rem;
      }

      .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
      }

      .remember-me {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: #666;
      }

      .forgot-password {
        font-size: 0.85rem;
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
      }

      .forgot-password:hover {
        text-decoration: underline;
      }

      .btn-login {
        width: 100%;
        padding: 11px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
      }

      .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
      }

      .divider {
        text-align: center;
        margin: 20px 0;
        position: relative;
      }

      .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e0e0e0;
      }

      .divider span {
        background: rgba(255, 255, 255, 0.95);
        padding: 0 15px;
        position: relative;
        color: #999;
        font-size: 0.9rem;
      }

      .register-link {
        text-align: center;
        font-size: 0.85rem;
        color: #666;
      }

      .register-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
      }

      .register-link a:hover {
        text-decoration: underline;
      }

      .demo-account {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
      }

      .demo-account p {
        margin: 0;
        font-size: 0.85rem;
        color: #666;
        text-align: center;
      }

      .demo-account p:first-child {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
      }

      .alert {
        position: fixed;
        top: 20px;
        right: 20px;
        width: auto;
        max-width: 400px;
        z-index: 9999;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
      }

      /* Estilos para el registro - Barra de progreso */
      .progress-section {
        margin-bottom: 20px;
      }

      .progress-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
      }

      .progress-text {
        font-size: 0.8rem;
        font-weight: 600;
        color: #333;
      }

      .progress-percentage {
        font-size: 0.8rem;
        font-weight: 600;
        color: #667eea;
      }

      .progress-bar-container {
        width: 100%;
        height: 6px;
        background: #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
      }

      .progress-bar-fill {
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        transition: width 0.4s ease;
      }

      /* Grupo de botones */
      .button-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        margin-top: 16px;
      }

      .btn-secondary-custom {
        padding: 11px;
        background: #f8f9fa;
        color: #333;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
      }

      .btn-secondary-custom:hover {
        background: #e0e0e0;
        border-color: #ccc;
      }

      /* Selects personalizados */
      select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23333' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 35px;
        cursor: pointer;
      }

      select.form-control:disabled {
        background-color: #f0f0f0;
        cursor: not-allowed;
        opacity: 0.6;
      }

      /* Botón deshabilitado */
      .btn-login:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none !important;
      }

      .btn-login:disabled:hover {
        transform: none !important;
        box-shadow: none !important;
      }

      @media (max-width: 992px) {
        .auth-container {
          flex-direction: column;
        }

        .left-side {
          padding: 40px 30px;
        }

        /* Ocultar las tarjetas de características en móvil */
        .features-grid {
          display: none;
        }

        .right-side {
          padding: 40px 30px;
        }

        .button-group {
          grid-template-columns: 1fr;
        }

        /* Centrar el logo en móvil */
        .logo-section {
          text-align: center;
        }

        .logo-section h1 {
          justify-content: center;
        }
      }
    </style>
  </head>

  <body>
    

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

    <div class="auth-container">
      <!-- Lado Izquierdo - Features -->
      <div class="left-side">
        <div class="logo-section">
          <h1>
            <img src="img/LHizki_Logo.png" alt="LHizki Logo" class="graduation-icon">
            LHizki
          </h1>
          <p>Ikasi euskarazko hitz teknikoak jolasean</p>
        </div>

        <div class="features-grid">
          <div class="feature-card">
            <i class="bi bi-controller"></i>
            <h3><?= t('juegos_semanales') ?></h3>
            <p><?= t('desc_juegos_semanales') ?></p>
          </div>

          <div class="feature-card">
            <i class="bi bi-trophy"></i>
            <h3><?= t('rankings') ?></h3>
            <p><?= t('desc_rankings') ?></p>
          </div>

          <div class="feature-card">
            <i class="bi bi-journal-text"></i>
            <h3><?= t('glosarios') ?></h3>
            <p><?= t('desc_glosarios') ?></p>
          </div>

         <div class="feature-card">
          <i class="bi bi-calendar2-week"></i>
          <h3><?= t('eventos') ?></h3>
          <p><?= t('desc_eventos') ?></p>
        </div>
        </div>
      </div>

      <!-- Lado Derecho - Formulario -->
      <div class="right-side">
        <div class="wave-decoration"></div>
        <?php 
          $view = "login"; // vista por defecto
          if (isset($_GET['section'])) {
            $view = $_GET['section'];
          }

          include "./sections/$view.php";
        ?>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Auto cerrar alertas después de 5 segundos
      setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
          const bsAlert = new bootstrap.Alert(alert);
          bsAlert.close();
        }
      }, 5000);

      // Toggle password visibility
      function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = event.currentTarget.querySelector('i');
        
        if (input.type === 'password') {
          input.type = 'text';
          icon.classList.remove('bi-eye');
          icon.classList.add('bi-eye-slash');
        } else {
          input.type = 'password';
          icon.classList.remove('bi-eye-slash');
          icon.classList.add('bi-eye');
        }
      }
    </script>
  </body>
</html>



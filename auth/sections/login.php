<?php
// Cargar sistema de traducciones
require_once __DIR__ . '/../../core/Helpers.php';
?>

<div class="form-container">
  <h2><?= t('iniciar_sesion') ?></h2>
  <p class="subtitle"><?= t('bienvenido_devuelta') ?></p>

  <form action="./controllers/login_controller.php" method="post">
    <!-- Campo Email -->
    <div class="form-group">
      <label for="email">
        <i class="bi bi-envelope"></i>
        <?= t('email') ?>
      </label>
      <input 
        type="email" 
        id="email" 
        name="email" 
        class="form-control" 
        placeholder="<?= t('tu_email') ?>"
        required
      />
    </div>

    <!-- Campo Contraseña -->
    <div class="form-group">
      <label for="password">
        <i class="bi bi-lock"></i>
        <?= t('contraseña') ?>
      </label>
      <div class="password-input-wrapper">
        <input 
          type="password" 
          id="password" 
          name="password" 
          class="form-control" 
          placeholder="••••••••"
          required
        />
        <button 
          type="button" 
          class="password-toggle" 
          onclick="togglePassword('password')"
          tabindex="-1"
        >
          <i class="bi bi-eye"></i>
        </button>
      </div>
    </div>

    <!-- Opciones del formulario -->
    <div class="form-options">
      <a href="#" class="forgot-password"><?= t('olvido_contraseña') ?></a>
    </div>

    <!-- Botón de login -->
    <button type="submit" class="btn-login">
      <i class="bi bi-box-arrow-in-right"></i>
      <?= t('iniciar_sesion') ?>
    </button>

    <!-- Divider -->
    <div class="divider">
      <span><?= t('o') ?></span>
    </div>

    <!-- Link de registro -->
    <div class="register-link">
      <?= t('no_tienes_cuenta') ?> <a href="index.php?section=registro"><?= t('registrate_aqui') ?></a>
    </div>
  </form>
</div>

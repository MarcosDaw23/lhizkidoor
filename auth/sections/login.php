<div class="form-container">
  <h2>Iniciar Sesión</h2>
  <p class="subtitle">Bienvenido de nuevo a LHizki</p>

  <form action="/lhizkidoor-juan/auth/controllers/login_controller.php" method="post">
    <!-- Campo Email -->
    <div class="form-group">
      <label for="email">
        <i class="bi bi-envelope"></i>
        Email
      </label>
      <input 
        type="email" 
        id="email" 
        name="email" 
        class="form-control" 
        placeholder="tu@email.com"
        required
      />
    </div>

    <!-- Campo Contraseña -->
    <div class="form-group">
      <label for="password">
        <i class="bi bi-lock"></i>
        Contraseña
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
      <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
    </div>

    <!-- Botón de login -->
    <button type="submit" class="btn-login">
      <i class="bi bi-box-arrow-in-right"></i>
      Iniciar Sesión
    </button>

    <!-- Divider -->
    <div class="divider">
      <span>o</span>
    </div>

    <!-- Link de registro -->
    <div class="register-link">
      ¿No tienes cuenta? <a href="index.php?section=registro">Regístrate aquí</a>
    </div>
  </form>
</div>

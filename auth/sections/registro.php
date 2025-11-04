<div class="form-container">
  <h2>Regístrate</h2>
  <p class="subtitle">Crea tu cuenta en LHizki</p>

  <!-- Barra de progreso -->
  <div class="progress-section">
    <div class="progress-info">
      <span id="etapa-texto" class="progress-text">Paso 1 de 2</span>
      <span id="etapa-porcentaje" class="progress-percentage">50%</span>
    </div>
    <div class="progress-bar-container">
      <div id="barra-progreso" class="progress-bar-fill" style="width: 50%;"></div>
    </div>
  </div>

  <form action="./controllers/registro_controller.php" method="post" id="registerForm">

    <!-- Paso 1: Centro, Sector y Clase -->
    <div id="step1">
      <div class="form-group">
        <label for="centro">
          <i class="bi bi-building"></i>
          Centro
        </label>
        <select name="centro" id="centro" class="form-control" required>
          <option value="">Selecciona un centro</option>
          <?php
          require_once './models/AccesoBD_class.php';
          $bd = new AccesoBD();
          $sql = "SELECT id, nombre FROM centro ORDER BY nombre";
          $resultado = $bd->lanzarSQL($sql);
          if ($resultado && mysqli_num_rows($resultado) > 0) {
            while ($row = mysqli_fetch_assoc($resultado)) {
              echo '<option value="'.$row['id'].'">'.htmlspecialchars($row['nombre']).'</option>';
            }
          } else {
            echo '<option value="">No hay centros disponibles</option>';
          }
          $bd->cerrarConexion();
          ?>
        </select>
      </div>

      <div class="form-group">
        <label for="sector">
          <i class="bi bi-diagram-3"></i>
          Sector
        </label>
        <select name="sector" id="sector" class="form-control" disabled required>
          <option value="">Selecciona primero un centro</option>
        </select>
      </div>

      <div class="form-group">
        <label for="clase">
          <i class="bi bi-people"></i>
          Clase
        </label>
        <select name="clase" id="clase" class="form-control" disabled required>
          <option value="">Selecciona primero un sector</option>
        </select>
      </div>

      <button type="button" id="btnNext" class="btn-login" disabled>
        <span>Siguiente</span>
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>

    <!-- Paso 2: Datos personales -->
    <div id="step2" style="display:none;">
      <div class="form-group">
        <label for="nombre">
          <i class="bi bi-person"></i>
          Nombre
        </label>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Tu nombre" required>
      </div>

      <div class="form-group">
        <label for="apellido">
          <i class="bi bi-person"></i>
          Apellido
        </label>
        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Tu apellido" required>
      </div>

      <div class="form-group">
        <label for="email">
          <i class="bi bi-envelope"></i>
          Correo electrónico
        </label>
        <input type="email" name="email" id="email" class="form-control" placeholder="tu@email.com" required>
      </div>

      <div class="form-group">
        <label for="password1">
          <i class="bi bi-lock"></i>
          Contraseña
        </label>
        <div class="password-input-wrapper">
          <input type="password" name="password1" id="password1" class="form-control" placeholder="••••••••" required>
          <button type="button" class="password-toggle" onclick="togglePassword('password1')" tabindex="-1">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="form-group">
        <label for="password2">
          <i class="bi bi-lock"></i>
          Repite la contraseña
        </label>
        <div class="password-input-wrapper">
          <input type="password" name="password2" id="password2" class="form-control" placeholder="••••••••" required>
          <button type="button" class="password-toggle" onclick="togglePassword('password2')" tabindex="-1">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="form-group">
        <label class="remember-me">
          <input type="checkbox" required id="form2Example3c">
          Acepto los <a href="#" class="forgot-password">términos de servicio</a>
        </label>
      </div>

      <div class="button-group">
        <button type="button" id="btnBack" class="btn-secondary-custom">
          <i class="bi bi-arrow-left"></i>
          Atrás
        </button>
        <button type="submit" class="btn-login">
          <i class="bi bi-check-circle"></i>
          Registrarme
        </button>
      </div>
    </div>
  </form>

  <!-- Link de login -->
  <div class="divider">
    <span>o</span>
  </div>

  <div class="register-link">
    ¿Ya tienes cuenta? <a href="index.php?section=login">Inicia sesión aquí</a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

  // es un script que junto a los controles, cargan los sectores, clases al cargar lo anterior, pa que tenga sentido la opcion
  //uso ajax para que solo recargue la parte del formualrio que quiero y asi no moleste la tonteria
  //ariba esta la url para implementar la libreria (cambairlo par que sea dinamico)
  $('#centro').on('change', function(){
    const centro_id = $(this).val();
    if(centro_id){
      $.ajax({
        type:'POST',
        url:'./controllers/getSectores_controller.php',
        data:{centro_id:centro_id},
        success:function(html){
          $('#sector').html(html).prop('disabled', false);
          $('#clase').html('<option value="">Selecciona primero un sector</option>').prop('disabled', true);
          validarPaso1();
        }
      }); 
    }else{
      $('#sector').html('<option value="">Selecciona primero un centro</option>').prop('disabled', true);
      $('#clase').html('<option value="">Selecciona primero un sector</option>').prop('disabled', true);
      validarPaso1();
    }
  });

  $('#sector').on('change', function(){
    const sector_id = $(this).val();
    if(sector_id){
      $.ajax({
        type:'POST',
        url:'./controllers/getClases_controller.php',
        data:{sector_id:sector_id},
        success:function(html){
          $('#clase').html(html).prop('disabled', false);
          validarPaso1();
        }
      }); 
    }else{
      $('#clase').html('<option value="">Selecciona primero un sector</option>').prop('disabled', true);
      validarPaso1();
    }
  });

  //esto activa el boton para pasar a la parte 2
  $('#clase, #sector, #centro').on('change', validarPaso1);

  function validarPaso1(){
    const centro = $('#centro').val();
    const sector = $('#sector').val();
    const clase = $('#clase').val();
    $('#btnNext').prop('disabled', !(centro && sector && clase));
  }

  $('#btnNext').on('click', function(){
    $('#step1').hide();
    $('#step2').fadeIn();
    actualizarBarra(100, 'Paso 2 de 2');
  });

  $('#btnBack').on('click', function(){
    $('#step2').hide();
    $('#step1').fadeIn();
    actualizarBarra(50, 'Paso 1 de 2');
  });

  function actualizarBarra(porcentaje, texto){
    $('#barra-progreso').css('width', porcentaje + '%').attr('aria-valuenow', porcentaje);
    $('#etapa-porcentaje').text(porcentaje + '%');
    $('#etapa-texto').text(texto);
  }

});
</script>

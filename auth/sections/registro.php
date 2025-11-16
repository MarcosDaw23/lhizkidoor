<?php
// Cargar sistema de traducciones
require_once __DIR__ . '/../../core/Helpers.php';
?>

<div class="form-container">
  <h2><?= t('registrate') ?></h2>
  <p class="subtitle"><?= t('crea_cuenta') ?></p>

  <!-- Barra de progreso -->
  <div class="progress-section">
    <div class="progress-info">
      <span id="etapa-texto" class="progress-text"><?= t('paso_1_de_2') ?></span>
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
          <?= t('centro') ?>
        </label>
        <select name="centro" id="centro" class="form-control" required>
          <option value=""><?= t('selecciona_centro') ?></option>
          <?php
          require_once __DIR__ . '/../../core/Database.php';
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
          <?= t('sector') ?>
        </label>
        <select name="sector" id="sector" class="form-control" disabled required>
          <option value=""><?= t('selecciona_sector') ?></option>
        </select>
      </div>

      <div class="form-group">
        <label for="clase">
          <i class="bi bi-people"></i>
          <?= t('clase') ?>
        </label>
        <select name="clase" id="clase" class="form-control" disabled required>
          <option value=""><?= t('selecciona_clase') ?></option>
        </select>
      </div>

      <div class="form-group">
        <label for="idioma">
          <i class="bi bi-translate"></i>
          <?= t('idioma') ?>
        </label>
        <select name="idioma" id="idioma" class="form-control" required>
          <option value=""><?= t('selecciona_idioma') ?></option>
          <option value="español"><?= t('español') ?></option>
          <option value="euskera"><?= t('euskera') ?></option>
        </select>
      </div>

      <button type="button" id="btnNext" class="btn-login" disabled>
        <span><?= t('siguiente') ?></span>
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>

    <!-- Paso 2: Datos personales -->
    <div id="step2" style="display:none;">
      <div class="form-group">
        <label for="nombre">
          <i class="bi bi-person"></i>
          <?= t('nombre') ?>
        </label>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="<?= t('tu_nombre') ?>" required>
      </div>

      <div class="form-group">
        <label for="apellido">
          <i class="bi bi-person"></i>
          <?= t('apellido') ?>
        </label>
        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="<?= t('tu_apellido') ?>" required>
      </div>

      <div class="form-group">
        <label for="email">
          <i class="bi bi-envelope"></i>
          <?= t('correo') ?>
        </label>
        <input type="email" name="email" id="email" class="form-control" placeholder="<?= t('tu_email') ?>" required>
      </div>

      <div class="form-group">
        <label for="password1">
          <i class="bi bi-lock"></i>
          <?= t('password') ?>
        </label>
        <div class="password-input-wrapper">
          <input type="password" name="password1" id="password1" class="form-control" placeholder="••••••••" required minlength="8">
          <button type="button" class="password-toggle" onclick="togglePassword('password1')" tabindex="-1">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="form-group">
        <label for="password2">
          <i class="bi bi-lock"></i>
          <?= t('repite_contraseña') ?>
        </label>
        <div class="password-input-wrapper">
          <input type="password" name="password2" id="password2" class="form-control" placeholder="••••••••" required minlength="8">
          <button type="button" class="password-toggle" onclick="togglePassword('password2')" tabindex="-1">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>

      <div class="form-group">
        <label class="remember-me">
          <input type="checkbox" required id="form2Example3c">
          <?= t('acepto_terminos') ?> <a href="#" class="forgot-password"><?= t('terminos_servicio') ?></a>
        </label>
      </div>

      <div class="button-group">
        <button type="button" id="btnBack" class="btn-secondary-custom">
          <i class="bi bi-arrow-left"></i>
          <?= t('atras') ?>
        </button>
        <button type="submit" class="btn-login">
          <i class="bi bi-check-circle"></i>
          <?= t('registrarme') ?>
        </button>
      </div>
    </div>
  </form>

  <!-- Link de login -->
  <div class="divider">
    <span><?= t('o') ?></span>
  </div>

  <div class="register-link">
    <?= t('ya_tienes_cuenta') ?> <a href="index.php?section=login"><?= t('inicia_sesion_aqui') ?></a>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

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

  $('#clase, #sector, #centro, #idioma').on('change', validarPaso1);

  function validarPaso1(){
    const centro = $('#centro').val();
    const sector = $('#sector').val();
    const clase = $('#clase').val();
    const idioma = $('#idioma').val();
    $('#btnNext').prop('disabled', !(centro && sector && clase && idioma));
  }

  $('#btnNext').on('click', function(){
    $('#step1').hide();
    $('#step2').fadeIn();
    actualizarBarra(100, '<?= t('paso_2_de_2') ?>');
  });

  $('#btnBack').on('click', function(){
    $('#step2').hide();
    $('#step1').fadeIn();
    actualizarBarra(50, '<?= t('paso_1_de_2') ?>');
  });

  function actualizarBarra(porcentaje, texto){
    $('#barra-progreso').css('width', porcentaje + '%').attr('aria-valuenow', porcentaje);
    $('#etapa-porcentaje').text(porcentaje + '%');
    $('#etapa-texto').text(texto);
  }

  // Validación de contraseña mínima antes de enviar
  $('#registerForm').on('submit', function(e){
    const pass1 = $('#password1').val();
    const pass2 = $('#password2').val();
    if(pass1.length < 8 || pass2.length < 8){
      alert('La contraseña debe tener al menos 8 caracteres.');
      e.preventDefault();
      return false;
    }
    // ...puedes agregar otras validaciones aquí...
  });

});
</script>

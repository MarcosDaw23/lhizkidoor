<div class="create-profesor-container">
  <div class="create-profesor-card">
    <div class="card-header-custom">
      <i class="bi bi-person-plus-fill"></i>
      <h1>Registrar Profesor</h1>
    </div>

    <div class="card-body-custom">
      <div class="progress-section">
        <div class="progress-info">
          <span id="etapa-texto" class="progress-step">
            <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
            Paso 1 de 2
          </span>
          <span id="etapa-porcentaje" class="progress-percentage">50%</span>
        </div>
        <div class="progress">
          <div id="barra-progreso" class="progress-bar" role="progressbar" 
               style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      </div>

      <form action="./controllers/registroProfesor_controller.php" method="post" id="registerForm">
        
        <!-- Paso 1: Centro, Sector y Clase -->
        <div id="step1" class="form-step">
          <div class="form-group-custom">
            <label class="form-label-custom" for="centro">
              <i class="bi bi-building"></i>
              Centro Educativo
            </label>
            <select name="centro" id="centro" class="form-select-custom" required>
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

          <div class="form-group-custom">
            <label class="form-label-custom" for="sector">
              <i class="bi bi-diagram-3"></i>
              Sector
            </label>
            <select name="sector" id="sector" class="form-select-custom" disabled required>
              <option value="">Selecciona primero un centro</option>
            </select>
          </div>

          <div class="form-group-custom">
            <label class="form-label-custom" for="clase">
              <i class="bi bi-mortarboard"></i>
              Clase
            </label>
            <select name="clase" id="clase" class="form-select-custom" disabled required>
              <option value="">Selecciona primero un sector</option>
            </select>
          </div>

          <div class="button-group button-group-center">
            <button type="button" id="btnNext" class="btn-custom btn-primary-custom" disabled>
              <span>Siguiente</span>
              <i class="bi bi-arrow-right"></i>
            </button>
          </div>
        </div>

        <!-- Paso 2: Datos del Profesor -->
        <div id="step2" class="form-step" style="display:none;">
          <div class="form-group-custom">
            <label class="form-label-custom" for="nombre">
              <i class="bi bi-person"></i>
              Nombre
            </label>
            <input type="text" name="nombre" id="nombre" class="form-control-custom" placeholder="Ingresa el nombre" required>
          </div>

          <div class="form-group-custom">
            <label class="form-label-custom" for="apellido">
              <i class="bi bi-person-badge"></i>
              Apellido
            </label>
            <input type="text" name="apellido" id="apellido" class="form-control-custom" placeholder="Ingresa el apellido" required>
          </div>

          <div class="form-group-custom">
            <label class="form-label-custom" for="email">
              <i class="bi bi-envelope"></i>
              Correo Electrónico
            </label>
            <input type="email" name="email" id="email" class="form-control-custom" placeholder="profesor@ejemplo.com" required>
          </div>

          <div class="form-group-custom">
            <label class="form-label-custom" for="password1">
              <i class="bi bi-lock"></i>
              Contraseña
            </label>
            <input type="password" name="password1" id="password1" class="form-control-custom" placeholder="Mínimo 8 caracteres" required>
          </div>

          <div class="form-group-custom">
            <label class="form-label-custom" for="password2">
              <i class="bi bi-lock-fill"></i>
              Confirmar Contraseña
            </label>
            <input type="password" name="password2" id="password2" class="form-control-custom" placeholder="Repite la contraseña" required>
          </div>

          <div class="button-group button-group-between">
            <button type="button" id="btnBack" class="btn-custom btn-secondary-custom">
              <i class="bi bi-arrow-left"></i>
              <span>Atrás</span>
            </button>
            <button type="submit" class="btn-custom btn-success-custom">
              <i class="bi bi-check-circle"></i>
              <span>Registrar</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

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
    $('#etapa-texto').html('<i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> ' + texto);
  }

});
</script>
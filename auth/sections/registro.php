<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <h1 class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Regístrate</h1>

                <div class="mb-4">
                  <div class="d-flex justify-content-between mb-1">
                    <span id="etapa-texto" class="fw-bold">Paso 1 de 2</span>
                    <span id="etapa-porcentaje">50%</span>
                  </div>
                  <div class="progress" style="height: 8px;">
                    <div id="barra-progreso" class="progress-bar bg-primary" role="progressbar" 
                         style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <form action="./controllers/registro_controller.php" method="post" id="registerForm" class="mx-1 mx-md-4">

                  <!-- parte 1, sector, clase y cenntro-->
                  <div id="step1">
                    <div class="mb-4">
                      <label class="form-label" for="centro">Centro</label>
                      <select name="centro" id="centro" class="form-select" required>
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

                    <div class="mb-4">
                      <label class="form-label" for="sector">Sector</label>
                      <select name="sector" id="sector" class="form-select" disabled required>
                        <option value="">Selecciona primero un centro</option>
                      </select>
                    </div>

                    <div class="mb-4">
                      <label class="form-label" for="clase">Clase</label>
                      <select name="clase" id="clase" class="form-select" disabled required>
                        <option value="">Selecciona primero un sector</option>
                      </select>
                    </div>

                    <div class="text-center">
                      <button type="button" id="btnNext" class="btn btn-primary btn-lg" disabled>Siguiente</button>
                    </div>
                  </div>

                  <!-- parte 2 con lo demas-->
                  <div id="step2" style="display:none;">
                    <div class="mb-4">
                      <label class="form-label" for="nombre">Nombre</label>
                      <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>

                    <div class="mb-4">
                      <label class="form-label" for="apellido">Apellido</label>
                      <input type="text" name="apellido" id="apellido" class="form-control" required>
                    </div>

                    <div class="mb-4">
                      <label class="form-label" for="email">Correo electrónico</label>
                      <input type="email" name="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-4">
                      <label class="form-label" for="password1">Contraseña</label>
                      <input type="password" name="password1" id="password1" class="form-control" required>
                    </div>

                    <div class="mb-4">
                      <label class="form-label" for="password2">Repite la contraseña</label>
                      <input type="password" name="password2" id="password2" class="form-control" required>
                    </div>

                    <div class="form-check d-flex justify-content-center mb-4">
                      <input class="form-check-input me-2" type="checkbox" required id="form2Example3c">
                      <label class="form-check-label" for="form2Example3c">
                        Acepto los <a href="#!">términos de servicio</a>
                      </label>
                    </div>

                    <div class="d-flex justify-content-between">
                      <button type="button" id="btnBack" class="btn btn-secondary">Atrás</button>
                      <button type="submit" class="btn btn-success">Registrarme</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

  // es un script que junto a los controles, cargan los sectores, clases al cargar lo anterior, pa que tenga sentido la opcion
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

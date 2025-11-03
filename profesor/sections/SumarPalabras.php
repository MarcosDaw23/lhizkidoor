<section class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-primary text-white text-center rounded-top-4">
      <h3 class="mb-0">Añadir nueva palabra</h3>
    </div>

    <div class="card-body p-4">
      <div class="mb-4">
        <label for="tipoEntrada" class="form-label fw-semibold">Seleccionar tipo de entrada</label>
        <select id="tipoEntrada" class="form-select">
          <option value="diccionario" selected>Diccionario</option>
          <option value="glosario">Glosario</option>
        </select>
      </div>

      <!-- 🟦 Formulario Diccionario -->
      <form id="formDiccionario" action="./controllers/SumarPalabraDiccionario_controller.php" method="POST" class="row g-3">
        <h5 class="text-secondary fw-bold">Añadir palabra al Diccionario</h5>

        <div class="col-md-6">
          <label for="rama" class="form-label fw-semibold">Rama</label>
          <select name="rama" id="rama" class="form-select" required>
            <option value="">Seleccione una rama</option>
            <?php
            require_once __DIR__ . '/../models/AccesoBD_class.php';
            $db = new AccesoBD_Profesor();
            $ramas = $db->obtenerTodasLasRamas();
            foreach ($ramas as $rama) {
              echo "<option value='{$rama['id']}'>{$rama['nombre']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="cast" class="form-label fw-semibold">Palabra en castellano</label>
          <input type="text" name="cast" id="cast" class="form-control" placeholder="Ej: Casa" required>
        </div>

        <div class="col-md-4">
          <label for="eusk1" class="form-label fw-semibold">Euskera 1</label>
          <input type="text" name="eusk1" id="eusk1" class="form-control" placeholder="Ej: Etxea">
        </div>

        <div class="col-md-4">
          <label for="eusk2" class="form-label fw-semibold">Euskera 2</label>
          <input type="text" name="eusk2" id="eusk2" class="form-control" placeholder="Ej: Etxeko">
        </div>

        <div class="col-md-4">
          <label for="eusk3" class="form-label fw-semibold">Euskera 3</label>
          <input type="text" name="eusk3" id="eusk3" class="form-control" placeholder="Ej: Etxetxo">
        </div>

        <div class="col-md-3">
          <label for="ondo" class="form-label fw-semibold">Opcion Correcta (1–3)</label>
          <input type="number" name="ondo" id="ondo" class="form-control" min="1" max="3" placeholder="1">
        </div>

        <div class="col-md-9">
          <label for="definicion" class="form-label fw-semibold">Definición</label>
          <textarea name="definicion" id="definicion" class="form-control" rows="3" placeholder="Escribe aquí la definición..." required></textarea>
        </div>

        <div class="col-12 text-center mt-3">
          <button type="submit" name="agregar_palabra" class="btn btn-success btn-lg px-5 shadow-sm">
            <i class="bi bi-save"></i> Guardar palabra en Diccionario
          </button>
        </div>
      </form>

      <form id="formGlosario" action="./controllers/SumarPalabraGlosario_controller.php" method="POST" class="row g-3 d-none">
        <h5 class="text-secondary fw-bold">Añadir palabra al Glosario</h5>

        <div class="col-md-6">
          <label for="ramaG" class="form-label fw-semibold">Rama</label>
          <select name="rama" id="ramaG" class="form-select" required>
            <option value="">Seleccione una rama</option>
            <?php
            require_once __DIR__ . '/../models/AccesoBD_class.php';
            $db = new AccesoBD_Profesor();
            $ramas = $db->obtenerTodasLasRamas();
            foreach ($ramas as $rama) {
              echo "<option value='{$rama['id']}'>{$rama['nombre']}</option>";
            }
            ?>
          </select>
        </div>

        <div class="col-md-6">
          <label for="castG" class="form-label fw-semibold">Palabra en castellano</label>
          <input type="text" name="cast" id="castG" class="form-control" placeholder="Ej: Innovación" required>
        </div>

        <div class="col-md-6">
          <label for="euskG" class="form-label fw-semibold">Palabra en euskera</label>
          <input type="text" name="eusk" id="euskG" class="form-control" placeholder="Ej: Berrikuntza" required>
        </div>

        <div class="col-md-6">
          <label for="definicionG" class="form-label fw-semibold">Definición</label>
          <textarea name="definicion" id="definicionG" class="form-control" rows="3" placeholder="Definición del término..." required></textarea>
        </div>

        <div class="col-12 text-center mt-3">
          <button type="submit" name="agregar_glosario" class="btn btn-warning btn-lg px-5 shadow-sm">
            <i class="bi bi-journal-plus"></i> Guardar palabra en Glosario
          </button>
        </div>
      </form>

    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const selector = document.getElementById("tipoEntrada");
  const formDiccionario = document.getElementById("formDiccionario");
  const formGlosario = document.getElementById("formGlosario");

  selector.addEventListener("change", () => {
    if (selector.value === "diccionario") {
      formDiccionario.classList.remove("d-none");
      formGlosario.classList.add("d-none");
    } else {
      formGlosario.classList.remove("d-none");
      formDiccionario.classList.add("d-none");
    }
  });
});
</script>

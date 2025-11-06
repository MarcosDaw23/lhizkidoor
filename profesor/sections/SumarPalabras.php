<section class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-primary text-white text-center rounded-top-4">
      <h3 class="mb-0">Añadir nueva palabra</h3>
    </div>

    <div class="card-body p-4">

      <!-- 🟦 Formulario Glosario -->
      <form id="formGlosario" action="./controllers/SumarPalabraGlosario_controller.php" method="POST" class="row g-3">
        <h5 class="text-secondary fw-bold">Añadir palabra al Glosario</h5>

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
        <?php
        if (isset($_SESSION['mensaje'])): ?>
          <div class="alert alert-<?php echo $_SESSION['tipo_mensaje']; ?> alert-dismissible fade show mt-3" role="alert">
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
            // Limpiamos la sesión para que no aparezca otra vez
            unset($_SESSION['mensaje'], $_SESSION['tipo_mensaje']);
        endif;
        ?>
      </form>
    </div>
  </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const selector = document.getElementById("tipoEntrada");
  const formGlosario = document.getElementById("formGlosario");
  const formGlosario = document.getElementById("formGlosario");

  selector.addEventListener("change", () => {
    if (selector.value === "Glosario") {
      formGlosario.classList.remove("d-none");
      formGlosario.classList.add("d-none");
    } else {
      formGlosario.classList.remove("d-none");
      formGlosario.classList.add("d-none");
    }
  });
});
</script>

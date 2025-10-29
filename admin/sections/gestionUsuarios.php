<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$bd = new AccesoBD_Admin();
$centros = $bd->obtenerCentros();
$sectores = $bd->obtenerSectores();
$clases = $bd->obtenerClases();

$usuarios = $_SESSION['usuarios'] ?? [];
unset($_SESSION['usuarios']);
?>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Gestion de Usuarios</h2>
  <form action="./controllers/filtrarUsuarios_controller.php" method="POST"
        class="d-flex flex-wrap align-items-center justify-content-center gap-2 mb-4 bg-light p-3 rounded shadow-sm">
    <input type="text" name="nombre" class="form-control flex-grow-1"
           placeholder="Buscar por nombre..." style="max-width: 200px;">

    <select name="centro" class="form-select" style="max-width: 180px;">
      <option value="">Centros</option>
      <?php foreach ($centros as $c): ?>
        <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <select name="sector" class="form-select" style="max-width: 180px;">
      <option value="">Sectores</option>
      <?php foreach ($sectores as $s): ?>
        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <select name="clase" class="form-select" style="max-width: 180px;">
      <option value="">Clases</option>
      <?php foreach ($clases as $cl): ?>
        <option value="<?= $cl['id'] ?>"><?= htmlspecialchars($cl['nombre']) ?></option>
      <?php endforeach; ?>
    </select>

    <select name="rol" class="form-select" style="max-width: 160px;">
      <option value="">Roles</option>
      <option value="1">Administrador</option>
      <option value="2">Profesor</option>
      <option value="3">Usuario</option>
    </select>

    <select name="ordenFecha" class="form-select" style="max-width: 220px;">
      <option value="DESC">Fecha mas reciente</option>
      <option value="ASC">Fecha mas antigua</option>
    </select>

    <button type="submit" class="btn btn-custom">Filtrar</button>
    <a href="./controllers/obtenerUsuarios_controller.php" class="btn btn-custom">Resetear</a>
  </form>

  <?php if (empty($usuarios)): ?>
    <div class="alert alert-warning text-center">
      No existen daros coincidentes
    </div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Rol</th>
            <th class="col-centro">Centro</th>
            <th>Sector</th>
            <th>Clase</th>
            <th>Fecha Confirmacion</th>
            <th class="text-center">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $u): ?>
            <tr>
              <td><?= htmlspecialchars($u['nombre']) ?></td>
              <td><?= htmlspecialchars($u['apellido']) ?></td>
              <td><?= htmlspecialchars($u['mail']) ?></td>
              <td>
                <?php 
                  switch ($u['rol']) {
                    case 1: echo "Administrador"; break;
                    case 2: echo "Profesor"; break;
                    default: echo "Usuario";
                  }
                ?>
              </td>
              <td class="text-wrap"><?= htmlspecialchars($u['centro'] ?? '-') ?></td>
              <td><?= htmlspecialchars($u['sector'] ?? '-') ?></td>
              <td><?= htmlspecialchars($u['clase'] ?? '-') ?></td>
              <td><?= htmlspecialchars($u['fechaConfirmacion'] ?? 'Pendiente') ?></td>
              <td class="text-center">
              <td class="text-center">
            <div class="d-flex justify-content-center gap-2">
                <a href="index.php?section=editarUsuarios&id=<?= $u['id'] ?>" 
                class="btn btn-sm btn-custom">Editar</a>
                <button type="button" 
                        class="btn btn-sm btn-custom" 
                        onclick="abrirModalBorrar(<?= $u['id'] ?>, '<?= htmlspecialchars($u['nombre']) ?>', '<?= htmlspecialchars($u['mail']) ?>')">
                Borrar
                </button>
            </div>
            </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<div class="modal fade" id="modalConfirmarBorrado" tabindex="-1" aria-labelledby="modalConfirmarBorradoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-secondary text-white">
        <h5 class="modal-title" id="modalConfirmarBorradoLabel">Confirmar borrado</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body text-center">
        <p id="mensajeModal" class="fs-5 mb-1"></p>
        <p id="correoModal" class="text-muted small mb-0"></p>
        <p class="text-muted small mt-3">Una vez borrado no vuelve</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-custom" data-bs-dismiss="modal">Cancelar</button>
        <a id="btnConfirmarBorrado" href="#" class="btn btn-custom">Eliminar</a>
      </div>
    </div>
  </div>
</div>

<script>
  let modalConfirmar;

  document.addEventListener('DOMContentLoaded', () => {
    modalConfirmar = new bootstrap.Modal(document.getElementById('modalConfirmarBorrado'));
  });

  function abrirModalBorrar(id, nombre, correo) {
    document.getElementById('mensajeModal').textContent = `¿Seguro que quieres eliminar al usuario "${nombre}"?`;
    document.getElementById('correoModal').textContent = correo;
    document.getElementById('btnConfirmarBorrado').href = `./controllers/borrarUsuarios_controller.php?id=${id}`;
    modalConfirmar.show();
  }
</script>

<style>
 /* 🔧 Ampliar el ancho del contenedor */
.container {
  max-width: 95% !important;
}

/* 🌍 Tabla sin scroll horizontal y cabecera completa */
.table-responsive {
  overflow-x: visible !important;
}

.table {
  width: 100% !important;
}

.table-dark th {
  background-color: #212529 !important;
  color: white;
  white-space: nowrap;
}

/* 📊 Ajuste de columnas */
.col-centro {
  min-width: 250px;
  white-space: normal !important;
}

/* 🧮 Filtros organizados */
form.d-flex {
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

form.d-flex select,
form.d-flex input {
  height: 38px;
}

/* 🧩 Botones de Filtrar y Resetear abajo centrados */
form.d-flex .btn-custom {
  display: block;
  margin-top: 10px;
  min-width: 120px;
}

form.d-flex .btn-custom:first-of-type {
  margin-right: 10px;
}

/* 📱 Responsive */
@media (max-width: 992px) {
  form.d-flex {
    flex-direction: column;
  }
  form.d-flex > * {
    width: 100% !important;
  }
}

/* 🎨 Botones suaves y modernos */
.btn-custom {
  background-color: #f9f9f9 !important; /* casi blanco */
  color: #007bff !important; /* azul claro */
  border: 1px solid #dcdcdc;
  font-weight: 500;
  transition: all 0.2s ease;
  border-radius: 0.4rem;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.btn-custom:hover {
  background-color: #f0f0f0 !important; /* leve gris cálido */
  color: #0056b3 !important;
  border-color: #cfcfcf;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Espaciado entre botones de acción en la tabla */
.table td .btn {
  margin: 0 4px;
}

/* 🎬 Animación modal */
.modal-content {
  border-radius: 1rem;
  animation: fadeIn 0.25s ease;
  background-color: #ffffff;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
}

@keyframes fadeIn {
  from {opacity: 0; transform: scale(0.95);}
  to {opacity: 1; transform: scale(1);}
}

</style>

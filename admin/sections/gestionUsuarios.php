<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$bd = new AccesoBD_Admin();
$centros = $bd->obtenerCentros();
$sectores = $bd->obtenerSectores();
$clases = $bd->obtenerClases();

$usuarios = $_SESSION['usuarios'] ?? [];
unset($_SESSION['usuarios']);
?>

<link rel="stylesheet" href="css/adminfinal.css">


<div class="users-header">
  <h1 class="users-title">Gestión de Usuarios</h1>
  <p class="users-subtitle">Administra todos los usuarios del sistema</p>
</div>

<!-- Filters Card -->
<div class="filters-card">
  <div class="filters-title">
    <i class="bi bi-funnel"></i>
    Filtros de Búsqueda
  </div>
  
  <form action="./controllers/filtrarUsuarios_controller.php" method="POST">
    <div class="filters-grid">
      <div class="filter-group">
        <label class="filter-label">
          <i class="bi bi-search"></i> Buscar
        </label>
        <input type="text" name="nombre" class="filter-input" placeholder="Nombre del usuario...">
      </div>

      <div class="filter-group">
        <label class="filter-label">
          <i class="bi bi-building"></i> Centro
        </label>
        <select name="centro" class="filter-select">
          <option value="">Todos los centros</option>
          <?php foreach ($centros as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="filter-group">
        <label class="filter-label">
          <i class="bi bi-person-badge"></i> Rol
        </label>
        <select name="rol" class="filter-select">
          <option value="">Todos los roles</option>
          <option value="1">Administrador</option>
          <option value="2">Profesor</option>
          <option value="3">Usuario</option>
        </select>
      </div>
       <div class="filters-actions">
        <button type="submit" class="btn-filter">
        <i class="bi bi-funnel-fill"></i>
        Aplicar Filtros
      </button>
      <a href="./controllers/obtenerUsuarios_controller.php" class="btn-reset">
        <i class="bi bi-arrow-clockwise"></i>
        Resetear
      </a>
      
    </div>
    </div>

   
  </form>
</div>

<!-- Users Table -->
<?php if (empty($usuarios)): ?>
  <div class="users-table-card">
    <div class="empty-state">
      <div class="empty-state-icon">
        <i class="bi bi-inbox"></i>
      </div>
      <h3 class="empty-state-title">No se encontraron usuarios</h3>
      <p class="empty-state-text">No hay datos que coincidan con los filtros seleccionados</p>
    </div>
  </div>
<?php else: ?>
  <div class="users-table-card">
    <table class="users-table">
      <thead>
        <tr>
          <th>Usuario</th>
          <th>Rol</th>
          <th>Centro</th>
          <th>Sector</th>
          <th>Clase</th>
          <th style="text-align: right;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td>
              <div class="user-name-cell">
                <div class="user-avatar-table">
                  <?= strtoupper(substr($u['nombre'], 0, 1)) ?>
                </div>
                <div class="user-info">
                  <div class="user-full-name">
                    <?= htmlspecialchars($u['nombre']) ?> <?= htmlspecialchars($u['apellido']) ?>
                  </div>
                  <div class="user-email"><?= htmlspecialchars($u['mail']) ?></div>
                </div>
              </div>
            </td>
            <td>
              <?php 
                $rolClass = '';
                $rolText = '';
                switch ($u['rol']) {
                  case 1: 
                    $rolClass = 'admin'; 
                    $rolText = 'Administrador'; 
                    break;
                  case 2: 
                    $rolClass = 'profesor'; 
                    $rolText = 'Profesor'; 
                    break;
                  default: 
                    $rolClass = 'usuario'; 
                    $rolText = 'Usuario';
                }
              ?>
              <span class="role-badge <?= $rolClass ?>"><?= $rolText ?></span>
            </td>
            <td><?= htmlspecialchars($u['centro'] ?? '-') ?></td>
            <td><?= htmlspecialchars($u['sector'] ?? '-') ?></td>
            <td><?= htmlspecialchars($u['clase'] ?? '-') ?></td>
            <td>
              <div class="actions-cell">
                <a href="index.php?section=editarUsuarios&id=<?= $u['id'] ?>" 
                   class="btn-action btn-edit">
                  <i class="bi bi-pencil"></i>
                  Editar
                </a>
                <button type="button" 
                        class="btn-action btn-delete" 
                        onclick="abrirModalBorrar(<?= $u['id'] ?>, '<?= htmlspecialchars($u['nombre']) ?> <?= htmlspecialchars($u['apellido']) ?>', '<?= htmlspecialchars($u['mail']) ?>')">
                  <i class="bi bi-trash"></i>
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

<!-- Modal Confirmar Borrado -->
<div class="modal fade" id="modalConfirmarBorrado" tabindex="-1" aria-labelledby="modalConfirmarBorradoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmarBorradoLabel">
          <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p class="modal-message" id="mensajeModal"></p>
        <p class="modal-email" id="correoModal"></p>
        <div class="modal-warning">
          <i class="bi bi-exclamation-circle"></i>
          <span>Esta acción no se puede deshacer. El usuario será eliminado permanentemente.</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-reset" data-bs-dismiss="modal">
          <i class="bi bi-x"></i>
          Cancelar
        </button>
        <a id="btnConfirmarBorrado" href="#" class="btn-filter" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
          <i class="bi bi-trash"></i>
          Eliminar Usuario
        </a>
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
    document.getElementById('mensajeModal').textContent = `¿Estás seguro de que deseas eliminar a "${nombre}"?`;
    document.getElementById('correoModal').textContent = correo;
    document.getElementById('btnConfirmarBorrado').href = `./controllers/borrarUsuarios_controller.php?id=${id}`;
    modalConfirmar.show();
  }
</script>

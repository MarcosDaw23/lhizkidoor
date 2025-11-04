<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

$bd = new AccesoBD_Admin();
$centros = $bd->obtenerCentros();
$sectores = $bd->obtenerSectores();
$clases = $bd->obtenerClases();

$usuarios = $_SESSION['usuarios'] ?? [];
unset($_SESSION['usuarios']);
?>

<style>
  .users-header {
    margin-bottom: 30px;
  }

  .users-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }

  .users-subtitle {
    color: #64748b;
    font-size: 1rem;
  }

  /* Filters Card */
  .filters-card {
    background: white;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 25px;
  }

  .filters-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
  }

  .filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }

  .filter-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .filter-input,
  .filter-select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #f8fafc;
  }

  .filter-input:focus,
  .filter-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  .filters-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
  }

  .btn-filter{
    height: 53px;
  }

  .btn-filter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 8px 14px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    
  }
  .filters-actions {
  margin-top: auto;
}

  .btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
  }
  .btn-reset{
    height: fit-content;
  }

  .btn-reset {
    background: white;
    color: #64748b;
    border: 2px solid #e2e8f0;
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .btn-reset:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #475569;
  }

  /* Users Table Card */
  .users-table-card {
    background: white;
    border-radius: 16px;
    padding: 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
  }

  .users-table {
    width: 100%;
    border-collapse: collapse;
  }

  .users-table thead {
    background: #f8fafc;
  }

  .users-table th {
    padding: 16px;
    text-align: left;
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e2e8f0;
  }

  .users-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.95rem;
    color: #1e293b;
  }

  .users-table tbody tr {
    transition: all 0.2s ease;
  }

  .users-table tbody tr:hover {
    background: #f8fafc;
  }

  .user-name-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .user-avatar-table {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 0.9rem;
    flex-shrink: 0;
  }

  .user-info {
    display: flex;
    flex-direction: column;
  }

  .user-full-name {
    font-weight: 600;
    color: #1e293b;
  }

  .user-email {
    font-size: 0.85rem;
    color: #64748b;
  }

  .role-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
  }

  .role-badge.admin {
    background: #fee2e2;
    color: #dc2626;
  }

  .role-badge.profesor {
    background: #dbeafe;
    color: #2563eb;
  }

  .role-badge.usuario {
    background: #d1fae5;
    color: #059669;
  }

  .status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
  }

  .status-badge.active {
    background: #d1fae5;
    color: #059669;
  }

  .status-badge.pending {
    background: #fef3c7;
    color: #d97706;
  }

  .actions-cell {
    display: flex;
    gap: 8px;
    justify-content: flex-end;
  }

  .btn-action {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
  }

  .btn-edit {
    background: #dbeafe;
    color: #2563eb;
  }

  .btn-edit:hover {
    background: #bfdbfe;
    color: #1d4ed8;
  }

  .btn-delete {
    background: #fee2e2;
    color: #dc2626;
  }

  .btn-delete:hover {
    background: #fecaca;
    color: #b91c1c;
  }

  .empty-state {
    text-align: center;
    padding: 60px 20px;
  }

  .empty-state-icon {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 20px;
  }

  .empty-state-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 10px;
  }

  .empty-state-text {
    color: #94a3b8;
  }

  /* Modal Styles */
  .modal-content {
    border-radius: 16px;
    border: none;
    overflow: hidden;
  }

  .modal-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 20px 25px;
  }

  .modal-title {
    color: white;
    font-weight: 700;
  }

  .modal-body {
    padding: 30px 25px;
  }

  .modal-message {
    font-size: 1.1rem;
    color: #1e293b;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .modal-email {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 20px;
  }

  .modal-warning {
    background: #fef3c7;
    color: #92400e;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .modal-footer {
    border: none;
    padding: 20px 25px;
    background: #f8fafc;
  }

  @media (max-width: 992px) {
    .filters-grid {
      grid-template-columns: 1fr;
    }

    .filters-actions {
      flex-direction: column;
    }

    .btn-filter, .btn-reset {
      width: 100%;
      justify-content: center;
    }

    .users-table-card {
      overflow-x: auto;
    }

    .actions-cell {
      flex-direction: column;
    }
  }
</style>

<!-- Header -->
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

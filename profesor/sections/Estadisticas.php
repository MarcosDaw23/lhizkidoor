<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] != 2) {
    header("Location: ../../auth/index.php?section=login");
    exit;
}

require_once __DIR__ . '/../models/AccesoBD_class.php';
$db = new AccesoBD_Profesor();
$estadisticas = $db->obtenerEstadisticasPartidas();
?>

<section class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-dark text-white text-center rounded-top-4">
      <h3 class="mb-0"><i class="bi bi-bar-chart-line"></i> Estadísticas de Partidas</h3>
    </div>
    <div class="card-body">
      <?php if (empty($estadisticas)): ?>
        <div class="alert alert-warning text-center">
          No hay partidas registradas aún.
        </div>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-dark text-center">
              <tr>
                <th>#</th>
                <th>Jugador</th>
                <th>Partidas Jugadas</th>
                <th>Total de Puntos</th>
                <th>Promedio</th>
                <th>Última Partida</th>
              </tr>
            </thead>
            <tbody class="text-center">
              <?php $i = 1; foreach ($estadisticas as $fila): ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td class="fw-semibold"><?= htmlspecialchars($fila['jugador']) ?></td>
                  <td><?= $fila['partidas_jugadas'] ?></td>
                  <td class="text-success fw-bold"><?= $fila['total_puntos'] ?></td>
                  <td><?= number_format($fila['promedio_puntos'], 2) ?></td>
                  <td><?= date("d/m/Y H:i", strtotime($fila['ultima_partida'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

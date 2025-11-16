<?php
require_once __DIR__ . '/../models/AccesoBD_class.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['evento'])) {


    echo "<div class='error-state'>
            <i class='bi bi-exclamation-circle'></i>
            <h3>No hay evento en la sesión</h3>
          </div>";
    return;
} else {
    $id_evento = $_SESSION['evento'];
}

$bd = new AccesoBD_Profesor();
$filas = $bd->obtenerPorEvento($id_evento);
?>

<link rel="stylesheet" href="css/profesorfinal.css">


<div class="ranking-evento-container">
    <div class="evento-header">
        <div class="evento-id-badge">
            <i class="bi bi-calendar-event-fill"></i>
            <span>Evento #<?php echo htmlspecialchars($id_evento); ?></span>
        </div>
        
        <button id="btnFinalizarEvento" class="btn-visualizar">
            <i class="bi bi-trophy-fill"></i>
            <span>Visualizar Ranking</span>
        </button>
    </div>

    <section id="seccionRanking" style="display:none;">
        <div class="ranking-card">
            <div class="ranking-header">
                <div class="ranking-title">
                    <i class="bi bi-trophy-fill"></i>
                    <span>Clasificación Final</span>
                </div>
            </div>

    <?php if (count($filas) > 0): ?>
                <div class="ranking-table-container">
                    <table class="ranking-table">
            <thead>
                <tr>
                    <th>Posición</th>
                    <th>Alumno</th>
                    <th>Puntuación</th>
                    <th>Aciertos</th>
                    <th>Fallos</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $posicion = 1;
                foreach ($filas as $fila): ?>
                    <tr>
                                    <td>
                                        <div class="position-cell">
                                            <span class="position-number"><?php echo $posicion++; ?></span>
                                        </div>
                                    </td>
                        <td><?php echo htmlspecialchars($fila['alumno']); ?></td>
                                    <td>
                                        <span class="score-badge">
                                            <i class="bi bi-star-fill"></i>
                                            <?php echo htmlspecialchars($fila['puntuacion']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="aciertos-badge">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <?php echo htmlspecialchars($fila['aciertos']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="fallos-badge">
                                            <i class="bi bi-x-circle-fill"></i>
                                            <?php echo htmlspecialchars($fila['fallos']); ?>
                                        </span>
                                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
                </div>

                <div class="action-buttons">
        <form action="./controllers/finalizarRankingEvento.php" method="POST" onsubmit="return confirmarFinalizacion();">
            <input type="hidden" name="id_evento" value="<?= $id_evento ?>">
                        <button type="submit" class="btn-finalizar">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>Finalizar Ranking</span>
                        </button>
        </form>
        <button id="btnRecargarRanking" class="btn-recargar">
                <i class="bi bi-arrow-clockwise"></i>
                <span>Recargar ranking</span>
        </button>
                </div>
    <?php else: ?>
                <div class="empty-ranking">
                    <i class="bi bi-inbox"></i>
                    <h3>No hay registros todavía</h3>
                    <p>Aún no hay participantes que hayan completado este evento.</p>
                    <button id="btnRecargarRanking" class="btn-recargar">
                        <i class="bi bi-arrow-clockwise"></i>
                        <span>Recargar ranking</span>
                    </button>
                </div>
    <?php endif; ?>
        </div>
</section>
</div>

<script>
document.getElementById('btnFinalizarEvento').addEventListener('click', function() {
    document.getElementById('seccionRanking').style.display = 'block';
    this.style.display = 'none';
});

function confirmarFinalizacion() {
    return confirm("¿Estás seguro de que quieres finalizar el ranking? No podrás volver a ver los resultados del evento");
}

const btnRecargar = document.getElementById('btnRecargarRanking');
if (btnRecargar) {
    btnRecargar.addEventListener('click', function() {
        location.reload();
    });
}
</script>

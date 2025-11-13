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

<style>
    .ranking-evento-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .evento-header {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        text-align: center;
    }

    .evento-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        margin-bottom: 20px;
    }

    .evento-id-badge i {
        font-size: 1.5rem;
    }

    .btn-visualizar {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 16px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-visualizar:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
    }

    .btn-visualizar i {
        font-size: 1.4rem;
    }

    .ranking-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        animation: fadeInScale 0.4s ease;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .ranking-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ranking-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .ranking-title i {
        font-size: 2rem;
    }

    .ranking-table-container {
        overflow-x: auto;
    }

    .ranking-table {
        width: 100%;
        border-collapse: collapse;
    }

    .ranking-table thead {
        background: #f7fafc;
    }

    .ranking-table thead th {
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #4a5568;
        border-bottom: 2px solid #e2e8f0;
    }

    .ranking-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .ranking-table tbody tr:hover {
        background: #f8fafc;
    }

    .ranking-table tbody tr:last-child {
        border-bottom: none;
    }

    .ranking-table tbody td {
        padding: 18px 20px;
        color: #2d3748;
        font-weight: 500;
    }

    .position-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .position-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #edf2f7;
        color: #4a5568;
        font-size: 0.95rem;
        font-weight: 700;
    }

    /* Top 3 Styling */
    .ranking-table tbody tr:nth-child(1) .position-number {
        background: linear-gradient(135deg, #ffd700, #ffed4e);
        color: #854d0e;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
    }

    .ranking-table tbody tr:nth-child(2) .position-number {
        background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
        color: #3f3f46;
        box-shadow: 0 2px 8px rgba(192, 192, 192, 0.3);
    }

    .ranking-table tbody tr:nth-child(3) .position-number {
        background: linear-gradient(135deg, #cd7f32, #e8a87c);
        color: #7c2d12;
        box-shadow: 0 2px 8px rgba(205, 127, 50, 0.3);
    }

    .ranking-table tbody tr:nth-child(1) {
        background: linear-gradient(to right, rgba(255, 215, 0, 0.05), transparent);
    }

    .ranking-table tbody tr:nth-child(2) {
        background: linear-gradient(to right, rgba(192, 192, 192, 0.05), transparent);
    }

    .ranking-table tbody tr:nth-child(3) {
        background: linear-gradient(to right, rgba(205, 127, 50, 0.05), transparent);
    }

    .score-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
    }

    .aciertos-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #2ed573, #1dd1a1);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .fallos-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .action-buttons {
        padding: 25px 30px;
        display: flex;
        gap: 15px;
        justify-content: center;
        background: #f7fafc;
    }

    .btn-finalizar {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, #2ed573, #1dd1a1);
        color: white;
        border: none;
        padding: 14px 30px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(46, 213, 115, 0.3);
    }

    .btn-finalizar:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(46, 213, 115, 0.4);
    }

    .btn-finalizar i {
        font-size: 1.2rem;
    }

    .empty-ranking {
        padding: 80px 20px;
        text-align: center;
        color: #718096;
    }

    .empty-ranking i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 20px;
    }

    .empty-ranking h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 12px;
    }

    .empty-ranking p {
        color: #a0aec0;
        font-size: 1rem;
        margin-bottom: 25px;
    }

    .btn-recargar {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #667eea;
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-recargar:hover {
        background: #5568d3;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-recargar i {
        font-size: 1.2rem;
    }

    .error-state {
        min-height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 40px;
    }

    .error-state i {
        font-size: 5rem;
        color: #ff6b6b;
        margin-bottom: 20px;
    }

    .error-state h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #2d3748;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .ranking-evento-container {
            padding: 20px 15px;
        }

        .evento-header {
            padding: 20px;
        }

        .ranking-header {
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }

        .ranking-title {
            font-size: 1.2rem;
        }

        .ranking-table thead th,
        .ranking-table tbody td {
            padding: 12px 15px;
            font-size: 0.9rem;
        }

        .position-number {
            width: 32px;
            height: 32px;
            font-size: 0.85rem;
        }

        .score-badge,
        .aciertos-badge,
        .fallos-badge {
            font-size: 0.85rem;
            padding: 6px 10px;
        }

        .action-buttons {
            flex-direction: column;
            padding: 20px;
        }
    }
</style>

<div class="ranking-evento-container">
    <!-- Header -->
    <div class="evento-header">
        <div class="evento-id-badge">
            <i class="bi bi-calendar-event-fill"></i>
            <span>Evento #<?php echo htmlspecialchars($id_evento); ?></span>
        </div>
        
        <!-- Botón para visualizar ranking -->
        <button id="btnFinalizarEvento" class="btn-visualizar">
            <i class="bi bi-trophy-fill"></i>
            <span>Visualizar Ranking</span>
        </button>
    </div>

    <!-- Contenedor de ranking (oculto inicialmente) -->
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

                <!-- Botones de acción -->
                <div class="action-buttons">
        <form action="./controllers/finalizarRankingEvento.php" method="POST">
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
// Mostrar la sección del ranking al pulsar "Visualizar Ranking"
document.getElementById('btnFinalizarEvento').addEventListener('click', function() {
    document.getElementById('seccionRanking').style.display = 'block';
    this.style.display = 'none';
});

// Recargar página para actualizar ranking
const btnRecargar = document.getElementById('btnRecargarRanking');
if (btnRecargar) {
    btnRecargar.addEventListener('click', function() {
        location.reload();
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="estadisticas-container">
  <div class="estadisticas-header">
    <h1 class="estadisticas-title">Participación de los Alumnos</h1>
    <p class="estadisticas-subtitle">Visualiza las estadísticas de participación por clase</p>
  </div>

  <?php
  require_once __DIR__ . '/../models/AccesoBD_class.php';
  $acceso = new AccesoBD_Profesor();
  $clases = $acceso->obtenerClases();
  ?>

  <div class="control-panel">
    <div class="form-group-stats">
      <label for="claseSelect" class="form-label-stats">Selecciona la clase</label>
      <select id="claseSelect" class="form-select-stats">
        <option value="">-- Selecciona una clase --</option>
        <?php foreach ($clases as $clase): ?>
          <option value="<?= $clase['id'] ?>"><?= htmlspecialchars($clase['nombre']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <button id="cargarGrafica" class="btn-cargar">
      <i class="bi bi-bar-chart-fill"></i> Cargar Gráfica
    </button>
  </div>

  <div class="grafica-container">
    <div id="emptyState" class="empty-state">
      <i class="bi bi-graph-up"></i>
      <p class="empty-state-text">Selecciona una clase y haz clic en "Cargar Gráfica" para ver las estadísticas</p>
    </div>
    <div class="canvas-wrapper" style="display: none;">
      <canvas id="graficaParticipacion"></canvas>
    </div>
  </div>
</div>

<script>
    // Inicializamos la variable global de la gráfica
    window.graficaParticipacion = null;

    document.getElementById('cargarGrafica').addEventListener('click', function() {
        const clase = document.getElementById('claseSelect').value;

        if (!clase) {
            alert('Por favor, selecciona una clase');
            return;
        }

        // Mostrar estado de carga
        document.getElementById('emptyState').style.display = 'none';
        document.querySelector('.canvas-wrapper').style.display = 'none';
        
        fetch(`controllers/ObtenerEstadisticas.php?clase=${clase}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backend:', data.mensaje);
                    document.getElementById('emptyState').innerHTML = `
                        <i class="bi bi-exclamation-triangle"></i>
                        <p class="empty-state-text">Error al cargar los datos</p>
                    `;
                    document.getElementById('emptyState').style.display = 'block';
                    return;
                }

                // Ocultar empty state y mostrar canvas
                document.getElementById('emptyState').style.display = 'none';
                document.querySelector('.canvas-wrapper').style.display = 'block';

                const ctx = document.getElementById('graficaParticipacion').getContext('2d');

                // Destruir la gráfica anterior solo si existe
                if (window.graficaParticipacion instanceof Chart) {
                    window.graficaParticipacion.destroy();
                }

                // Crear nueva gráfica con colores profesionales
                window.graficaParticipacion = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Han jugado', 'No han jugado'],
                        datasets: [{
                            data: [data.jugados, data.no_jugados],
                            backgroundColor: [
                                'rgba(102, 126, 234, 0.8)',
                                'rgba(203, 213, 225, 0.8)'
                            ],
                            borderColor: [
                                'rgba(102, 126, 234, 1)',
                                'rgba(203, 213, 225, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { 
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            title: { 
                                display: true, 
                                text: `Total de alumnos: ${data.total}`,
                                font: {
                                    size: 16,
                                    weight: 'bold'
                                },
                                padding: 20
                            }
                        }
                    }
                });
            })
            .catch(err => {
                console.error('Error cargando datos:', err);
                document.getElementById('emptyState').innerHTML = `
                    <i class="bi bi-exclamation-triangle"></i>
                    <p class="empty-state-text">Error de conexión. Intenta nuevamente.</p>
                `;
                document.getElementById('emptyState').style.display = 'block';
            });
    });
</script>

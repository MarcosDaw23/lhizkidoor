<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
  .estadisticas-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
  }

  .estadisticas-header {
    text-align: center;
    margin-bottom: 40px;
  }

  .estadisticas-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
  }

  .estadisticas-subtitle {
    color: #64748b;
    font-size: 1rem;
  }

  .control-panel {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    margin-bottom: 30px;
  }

  .form-group-stats {
    margin-bottom: 20px;
  }

  .form-label-stats {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
  }

  .form-select-stats {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.2s;
    background: white;
  }

  .form-select-stats:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  .btn-cargar {
    width: 100%;
    padding: 12px 24px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
  }

  .btn-cargar:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
  }

  .grafica-container {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .canvas-wrapper {
    max-width: 500px;
    width: 100%;
    margin: 0 auto;
  }

  .empty-state {
    text-align: center;
    color: #94a3b8;
    padding: 60px 20px;
  }

  .empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    color: #cbd5e1;
  }

  .empty-state-text {
    font-size: 1.1rem;
    color: #64748b;
  }

  @media (max-width: 768px) {
    .estadisticas-container {
      padding: 16px;
    }

    .control-panel,
    .grafica-container {
      padding: 20px;
    }

    .estadisticas-title {
      font-size: 1.5rem;
    }
  }
</style>

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

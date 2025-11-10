<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: Arial; text-align: center; margin-top: 50px; }
    canvas { max-width: 500px; margin: auto; }
</style>
<section>
  <h2>🎮 Participación de los Alumnos</h2>
  <?php
  require_once __DIR__ . '/../models/AccesoBD_class.php';
  $acceso = new AccesoBD_Profesor();
  $clases = $acceso->obtenerClases();
  ?>

  <label for="claseSelect">Selecciona la clase:</label>
  <select id="claseSelect">
      <?php foreach ($clases as $clase): ?>
          <option value="<?= $clase['id'] ?>"><?= htmlspecialchars($clase['nombre']) ?></option>
      <?php endforeach; ?>
  </select>

  <button id="cargarGrafica">Cargar Gráfica</button>

  <canvas id="graficaParticipacion"></canvas>

  <script>
    // Inicializamos la variable global de la gráfica
    window.graficaParticipacion = null;

    document.getElementById('cargarGrafica').addEventListener('click', function() {
        const clase = document.getElementById('claseSelect').value;

        fetch(`controllers/ObtenerEstadicticas.php?clase=${clase}`)
            .then(res => res.json())
            .then(data => {
                if (data.error) {
                    console.error('Error backend:', data.mensaje);
                    return;
                }

                const ctx = document.getElementById('graficaParticipacion').getContext('2d');

                // Destruir la gráfica anterior solo si existe
                if (window.graficaParticipacion instanceof Chart) {
                    window.graficaParticipacion.destroy();
                }

                // Crear nueva gráfica
                window.graficaParticipacion = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Han jugado', 'No han jugado'],
                        datasets: [{
                            data: [data.jugados, data.no_jugados],
                            backgroundColor: ['rgba(75, 192, 192, 0.7)', 'rgba(255, 99, 132, 0.7)'],
                            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { position: 'bottom' },
                            title: { display: true, text: `Total de alumnos: ${data.total}` }
                        }
                    }
                });
            })
            .catch(err => console.error('Error cargando datos:', err));
    });
  </script>
</section>

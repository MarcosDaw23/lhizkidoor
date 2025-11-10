<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: Arial; text-align: center; margin-top: 50px; }
    canvas { max-width: 500px; margin: auto; }
</style>
<section>
  <h2>🎮 Participación de los Alumnos</h2>
  <canvas id="graficaParticipacion"></canvas>

  <script>
    fetch('controllers/ObtenerEstadicticas.php')
      .then(res => res.json())
      .then(data => {
        const ctx = document.getElementById('graficaParticipacion').getContext('2d');
        new Chart(ctx, {
          type: 'pie',
          data: {
            labels: ['Han jugado', 'No han jugado'],
            datasets: [{
              data: [data.jugados, data.no_jugados],
              backgroundColor: [
                'rgba(75, 192, 192, 0.7)',   // verde
                'rgba(255, 99, 132, 0.7)'    // rojo
              ],
              borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)'
              ],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { position: 'bottom' },
              title: {
                display: true,
                text: `Total de alumnos: ${data.total}`
              }
            }
          }
        });
      })
      .catch(error => console.error('Error cargando datos:', error));
  </script>
</section>

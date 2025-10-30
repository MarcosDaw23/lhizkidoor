<?php
$yaJugo = $_SESSION['yaJugo'] ?? false;
?>

<div class="container text-center mt-5">
  <h2 class="mb-4 fw-bold">Elige un modo de juego</h2>

  <div class="d-flex flex-column align-items-center gap-3">

    <?php if (!$yaJugo): ?>
      <p class="mt-3">Aún no has jugado esta semana</p>
      <a href="./controllers/PartidaSemanal_controller.php?action=jugar"
         class="btn btn-lg w-75 py-4 fw-bold text-white"
         style="background-color:#007bff; border-radius:20px; font-size:1.3rem; box-shadow:0 4px 8px rgba(0,0,0,0.2);">
         🎮 Jugar partida semanal
      </a>
    <?php else: ?>
      <div class="mt-3 text-center">
        <p class="fw-semibold text-danger mb-1">Ya jugaste esta semana</p>
        <h5>Próxima partida disponible en:</h5>
        <div id="cronometro"
             class="fs-3 fw-bold text-info bg-dark bg-opacity-75 rounded-4 px-4 py-2 mt-2 d-inline-block shadow">
        </div>
      </div>
    <?php endif; ?>

   <a href="./controllers/Preguntas_controller.php?action=start"
   class="btn btn-md w-75 py-3 fw-semibold text-white"
   style="background-color:#28a745; border-radius:15px; font-size:1rem;">
   Preguntas preguntosas
</a>


    <a href="./controllers/nsq_controller.php"
       class="btn btn-md w-75 py-3 fw-semibold text-white"
       style="background-color:#ffc107; border-radius:15px; font-size:1rem;">
       Escribe la palabra en castellano
    </a>

    <a href="./controllers/nsq_controller.php"
       class="btn btn-md w-75 py-3 fw-semibold text-white"
       style="background-color:#dc3545; border-radius:15px; font-size:1rem;">
       Posible ahorcado
    </a>

  </div>
</div>

<?php if ($yaJugo): ?>
<script>
  // Cronómetro hasta el próximo lunes 1:00 AM
  function calcularProximoLunes() {
    const ahora = new Date();
    const proximoLunes = new Date(ahora);
    const dia = ahora.getDay();
    const diasParaLunes = (8 - dia) % 7;
    proximoLunes.setDate(ahora.getDate() + diasParaLunes);
    proximoLunes.setHours(1, 0, 0, 0);
    if (ahora > proximoLunes) proximoLunes.setDate(proximoLunes.getDate() + 7);
    return proximoLunes;
  }

  function iniciarCuentaRegresiva() {
    const destino = calcularProximoLunes();
    const intervalo = setInterval(() => {
      const ahora = new Date();
      const diff = destino - ahora;
      if (diff <= 0) {
        clearInterval(intervalo);
        document.getElementById("cronometro").innerHTML = "¡Ya puedes jugar la nueva partida semanal!";
        location.reload(); 
        return;
      }

      const d = Math.floor(diff / (1000 * 60 * 60 * 24));
      const h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const s = Math.floor((diff % (1000 * 60)) / 1000);
      document.getElementById("cronometro").innerHTML = `${d}d ${h}h ${m}m ${s}s`;
    }, 1000);
  }

  iniciarCuentaRegresiva();
</script>
<?php endif; ?>

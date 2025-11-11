<?php
require_once 'AccesoBD.php';

// Verificar si existe un id_evento (por ejemplo desde la URL o la sesión)
session_start();
$id_evento = $_SESSION['evento'] ?? null;

if (!$id_evento) {
    echo "<p>No se especificó ningún evento.</p>";
    exit;
}

$bd = new AccesoBD_Profesor();
$filas = $bd->obtenerPorEvento($id_evento);

?>

<!-- Botón para finalizar evento -->
<button id="btnFinalizarEvento">Finalizar evento</button>

<!-- Contenedor oculto inicialmente -->
<section id="seccionRanking" class="tabla-ranking" style="display:none;">
    <h2>Ranking del evento #<?php echo htmlspecialchars($id_evento); ?></h2>

    <?php if (count($filas) > 0): ?>
        <table border="1" cellpadding="8" cellspacing="0">
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
                        <td><?php echo $posicion++; ?></td>
                        <td><?php echo htmlspecialchars($fila['alumno']); ?></td>
                        <td><?php echo htmlspecialchars($fila['puntuacion']); ?></td>
                        <td><?php echo htmlspecialchars($fila['aciertos']); ?></td>
                        <td><?php echo htmlspecialchars($fila['fallos']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <!-- Botón para finalizar ranking -->
        <button id="btnFinalizarRanking">Finalizar ranking</button>
    <?php else: ?>
        <p>No hay registros en este evento todavía.</p>
    <?php endif; ?>
</section>

<script>
// Mostrar la sección del ranking al pulsar "Finalizar evento"
document.getElementById('btnFinalizarEvento').addEventListener('click', function() {
    document.getElementById('seccionRanking').style.display = 'block';
    this.style.display = 'none'; // Oculta el botón de "Finalizar evento"
});

// Acción al pulsar "Finalizar ranking"
document.getElementById('btnFinalizarRanking')?.addEventListener('click', function() {
    <?php
        $bd->eliminarPorEvento($id_evento);
        header("Location: index.php");
        exit;
    ?>
    // Aquí puedes hacer lo que necesites, por ejemplo:
    alert('El ranking ha sido finalizado.');

});
</script>

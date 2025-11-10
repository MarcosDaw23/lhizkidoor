<?php
require_once 'AccesoBD.php';
require_once 'EventoRanking.php';

// Verificar si existe un id_evento (por ejemplo desde la URL o la sesión)
$id_evento = $_SESSION['evento'];

if (!$id_evento) {
    echo "<p>No se especificó ningún evento.</p>";
    exit;
}

$ranking = new EventoRanking();
$filas = $ranking->obtenerPorEvento($id_evento);
?>

<section class="tabla-ranking">
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
    <?php else: ?>
        <p>No hay registros en este evento todavía.</p>
    <?php endif; ?>
</section>
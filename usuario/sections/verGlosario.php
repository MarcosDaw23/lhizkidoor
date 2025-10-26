<?php
//mirar bd, la parte del diccionario, para representaer en el glosario, la parte de euskera duda
$diccionario = $_SESSION['diccionario'] ?? [];
$ramas = $_SESSION['ramas'] ?? [];
$ramaSeleccionada = $_SESSION['ramaSeleccionada'] ?? '';
?>

<div class="container mt-4">
<h2 class="text-center mb-4">glosario (diccionario en bd)</h2>

<form id="filtroGlosario" method="GET" action="<?php echo './controllers/obtenerGlosario_controller.php'; ?>" class="d-flex flex-wrap justify-content-center gap-2 mb-4">

    <input type="text" name="buscar" id="buscar" class="form-control"
    placeholder="Buscar palabra..." style="max-width: 250px;">

    <select name="rama" id="rama" class="form-select" style="max-width: 200px;">
    <?php foreach ($ramas as $r): ?>
        <option value="<?= $r['id'] ?>" <?= $r['id'] == $ramaSeleccionada ? 'selected' : '' ?>>
        <?= htmlspecialchars($r['nombre']) ?>
        </option>
    <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-primary">filtrar</button>
</form>

<?php if (empty($diccionario)): ?>
    <div class="alert alert-warning text-center">No se encontraron resultados</div>
<?php else: ?>
    <div class="table-responsive">
    <table id="tablaGlosario" class="table table-striped table-hover align-middle">
        <thead class="table-dark">
        <tr>
            <th>Castellano</th>
            <th>Euskera 1</th>
            <th>Euskera 2</th>
            <th>Euskera 3</th>
            <th>Definición</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($diccionario as $d): ?>
            <tr>
            <td><?= htmlspecialchars($d['cast']) ?></td>
            <td><?= htmlspecialchars($d['eusk1']) ?></td>
            <td><?= htmlspecialchars($d['eusk2']) ?></td>
            <td><?= htmlspecialchars($d['eusk3']) ?></td>
            <td><?= htmlspecialchars($d['definicion']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
</div>

<script>
//mocer todos los script a la carpeta js pa ponerlo limpio
document.addEventListener('DOMContentLoaded', () => {
const buscarInput = document.getElementById('buscar');
const tabla = document.getElementById('tablaGlosario');
const filas = tabla ? tabla.getElementsByTagName('tr') : [];
const ramaSelect = document.getElementById('rama');
const form = document.getElementById('filtroGlosario');

buscarInput.addEventListener('input', () => {
    const filtro = buscarInput.value.toLowerCase();
//pa recoorer lasfilas quitando el encabezado
    for (let i = 1; i < filas.length; i++) {
    const celdas = filas[i].getElementsByTagName('td');
    let coincide = false;

    for (let j = 0; j < celdas.length; j++) {
        if (celdas[j].textContent.toLowerCase().includes(filtro)) {
        coincide = true;
        break;
        }
    }

    filas[i].style.display = coincide ? '' : 'none';
    }
});
//evento pa limpiar el select d ela rama
ramaSelect.addEventListener('change', () => {
    buscarInput.value = ''; 
});
});
</script>

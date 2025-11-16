<?php
$glosario = $_SESSION['glosario'] ?? [];
$ramas = $_SESSION['ramas'] ?? [];
$ramaSeleccionada = $_SESSION['ramaSeleccionada'] ?? '';
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">

<div class="glossary-container">
    <div class="glossary-header">
        <h1 class="glossary-title">
            <i class="bi bi-book-fill"></i>
            Glosario Técnico
        </h1>
        <p class="glossary-subtitle">Explora y aprende vocabulario técnico en euskera</p>
    </div>

    <div class="filter-section">
        <form id="filtroGlosario" method="GET" action="./controllers/obtenerGlosario_controller.php" class="filter-form">
            <input type="text" 
                   name="buscar" 
                   id="buscar" 
                   class="filter-input"
                   placeholder="Buscar palabra...">

            <select name="rama" id="rama" class="filter-select">
    <?php foreach ($ramas as $r): ?>
        <option value="<?= $r['id'] ?>" <?= $r['id'] == $ramaSeleccionada ? 'selected' : '' ?>>
        <?= htmlspecialchars($r['nombre']) ?>
        </option>
    <?php endforeach; ?>
    </select>

            <button type="submit" class="filter-btn">
                <i class="bi bi-funnel-fill"></i> Filtrar
            </button>
</form>
    </div>

<?php if (empty($glosario)): ?>
        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-inbox"></i>
            </div>
            <h3 class="empty-title">No se encontraron resultados</h3>
            <p class="empty-text">Intenta con otros términos de búsqueda o cambia la categoría</p>
        </div>
<?php else: ?>
        <div class="table-container">
            <table class="glossary-table" id="glossaryTable">
                <thead>
                    <tr>
                        <th class="col-spanish">Castellano</th>
                        <th class="col-euskera">Euskera</th>
                        <th class="col-definition">Definición</th>
                    </tr>
                </thead>
                <tbody id="glossaryGrid">
                    <?php foreach ($glosario as $d): ?>
                    <tr>
                        <td class="col-spanish" data-label="Castellano"><?= htmlspecialchars($d['cast']) ?></td>
                        <td class="col-euskera" data-label="Euskera"><?= htmlspecialchars($d['eusk']) ?></td>
                        <td class="col-definition" data-label="Definición"><?= htmlspecialchars($d['definicion']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
<?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buscarInput = document.getElementById('buscar');
    const glossaryGrid = document.getElementById('glossaryGrid');
    const tableRows = glossaryGrid ? glossaryGrid.getElementsByTagName('tr') : [];
    const ramaSelect = document.getElementById('rama');

    if (buscarInput && tableRows.length > 0) {
        buscarInput.addEventListener('input', () => {
            const filtro = buscarInput.value.toLowerCase();
            
            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const texto = row.textContent.toLowerCase();
                
                if (texto.includes(filtro)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    if (ramaSelect) {
        ramaSelect.addEventListener('change', () => {
            buscarInput.value = ''; 
        });
    }
});
</script>

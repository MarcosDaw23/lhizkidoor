<?php
$glosario = $_SESSION['glosario'] ?? [];
$ramas = $_SESSION['ramas'] ?? [];
$ramaSeleccionada = $_SESSION['ramaSeleccionada'] ?? '';
?>

<style>
    .glossary-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .glossary-header {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 40px;
        border-radius: 25px;
        text-align: center;
        margin-bottom: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .glossary-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #ff6b6b 0%, #4facfe 50%, #00f2fe 100%);
    }

    .glossary-title {
        font-size: 2.8rem;
        font-weight: 900;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        display: inline-flex;
        align-items: center;
        gap: 15px;
    }

    .glossary-title i {
        font-size: 2.5rem;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    .glossary-subtitle {
        font-size: 1.1rem;
        color: #666;
        font-weight: 500;
    }

    .filter-section {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        padding: 35px;
        margin-bottom: 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 15px;
        align-items: center;
    }

    .filter-input {
        padding: 16px 24px;
        border: 2px solid rgba(255, 107, 107, 0.2);
        background: white;
        border-radius: 15px;
        font-size: 1rem;
        color: #333;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .filter-input::placeholder {
        color: #999;
    }

    .filter-input:focus {
        outline: none;
        border-color: #ff6b6b;
        box-shadow: 0 5px 20px rgba(255, 107, 107, 0.2);
        transform: translateY(-2px);
    }

    .filter-select {
        min-width: 250px;
        padding: 16px 24px;
        border: 2px solid rgba(79, 172, 254, 0.2);
        background: white;
        border-radius: 15px;
        font-size: 1rem;
        color: #333;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .filter-select:focus {
        outline: none;
        border-color: #4facfe;
        box-shadow: 0 5px 20px rgba(79, 172, 254, 0.2);
        transform: translateY(-2px);
    }

    .filter-btn {
        padding: 16px 40px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        border: none;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(255, 107, 107, 0.3);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(255, 107, 107, 0.4);
    }

    .filter-btn:active {
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 25px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .empty-icon {
        font-size: 5rem;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 25px;
        animation: floatIcon 3s ease-in-out infinite;
    }

    @keyframes floatIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .empty-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #333;
        margin-bottom: 12px;
    }

    .empty-text {
        color: #666;
        font-size: 1rem;
    }

    .table-container {
        background: white;
        border-radius: 20px;
        padding: 0;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: 1px solid rgba(79, 172, 254, 0.1);
    }

    .glossary-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.95rem;
    }

 .glossary-table thead {
    background: rgba(255, 255, 255, 0.35);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    color: #2c3e50;
    position: relative;
    font-weight: 700;
}

    .glossary-table thead::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #ff6b6b 0%, #4facfe 100%);
    }
    .glossary-table thead::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(215, 38, 56, 0.25), rgba(0, 127, 95, 0.25));
    z-index: -1;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1);
}

    .glossary-table thead th {
        padding: 20px 24px;
        text-align: left;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        font-size: 0.85rem;
        position: relative;
    }

    .glossary-table thead th:not(:last-child)::after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 24px;
        width: 1px;
        background: rgba(255, 255, 255, 0.3);
    }

    .glossary-table tbody tr {
        transition: all 0.3s ease;
        position: relative;
    }

    .glossary-table tbody tr::after {
        content: '';
        position: absolute;
        left: 20px;
        right: 20px;
        bottom: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #e8e8e8 50%, transparent);
    }

    .glossary-table tbody tr:last-child::after {
        display: none;
    }

    .glossary-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        transform: scale(1.01);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .glossary-table tbody td {
        padding: 20px 24px;
        vertical-align: top;
    }

    .glossary-table .col-spanish {
        font-weight: 700;
        color: #000;
        width: 25%;
        position: relative;
    }

.glossary-table .col-spanish::before {
    content: '';
    display: inline-block;
    width: 20px;
    height: 14px;
    margin-right: 8px;
    background-image: url('https://flagcdn.com/es.svg');
    background-size: cover;
    background-position: center;
    border-radius: 2px;
    vertical-align: middle;
}

    .glossary-table .col-euskera {
        font-weight: 600;
        color: #667eea;
        width: 25%;
        position: relative;
    }
.glossary-table .col-euskera::before {
    content: '';
    display: inline-block;
    width: 20px;
    height: 14px;
    margin-right: 8px;
    background-image: url('https://upload.wikimedia.org/wikipedia/commons/2/2d/Flag_of_the_Basque_Country.svg'); /* Ikurriña */
    background-size: cover;
    background-position: center;
    border-radius: 2px;
    vertical-align: middle;
}

    .glossary-table .col-definition {
        color: #555;
        line-height: 1.7;
        width: 50%;
        font-weight: 500;
    }

    .glossary-table tbody tr:nth-child(even) {
        background: rgba(247, 250, 252, 0.5);
    }

    .glossary-table tbody tr:nth-child(even):hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
    }

    @media (max-width: 768px) {
        .glossary-container {
            padding: 15px;
        }

        .glossary-header {
            padding: 30px 20px;
        }

        .glossary-title {
            font-size: 2.2rem;
            flex-direction: column;
            gap: 10px;
        }

        .glossary-subtitle {
            font-size: 0.95rem;
        }

        .filter-section {
            padding: 25px 20px;
        }

        .filter-form {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .filter-input,
        .filter-select,
        .filter-btn {
            width: 100%;
            min-width: auto;
        }

        .table-container {
            border-radius: 12px;
            box-shadow: none;
        }

        /* Ocultar el header de la tabla en móvil */
        .glossary-table thead {
            display: none;
        }

        /* Convertir cada fila en una tarjeta */
        .glossary-table tbody tr {
            display: block;
            background: white;
            border-radius: 16px;
            margin-bottom: 15px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #e8e8e8;
        }

        .glossary-table tbody tr::after {
            display: none;
        }

        .glossary-table tbody tr:hover {
            transform: none;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .glossary-table tbody tr:nth-child(even) {
            background: white;
        }

        /* Hacer que cada celda sea un bloque con su etiqueta */
        .glossary-table tbody td {
            display: block;
            width: 100%;
            padding: 10px 0;
            border: none;
        }

        .glossary-table tbody td::before {
            content: attr(data-label);
            display: block;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }

        .glossary-table .col-spanish,
        .glossary-table .col-euskera,
        .glossary-table .col-definition {
            width: 100%;
        }

        .glossary-table .col-spanish {
            font-size: 1.2rem;
            padding-bottom: 12px;
            border-bottom: 2px solid #f0f0f0;
        }

        .glossary-table .col-euskera {
            font-size: 1.1rem;
            padding-top: 12px;
        }

        .glossary-table .col-definition {
            font-size: 0.9rem;
            padding-top: 8px;
            color: #666;
        }
    }
</style>

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

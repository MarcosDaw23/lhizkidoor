<?php
$glosario = $_SESSION['glosario'] ?? [];
$ramas = $_SESSION['ramas'] ?? [];
$ramaSeleccionada = $_SESSION['ramaSeleccionada'] ?? '';
?>

<style>
    .glossary-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .glossary-header {
        text-align: left;
        margin-bottom: 40px;
        animation: slideInLeft 0.6s ease;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .glossary-title {
        font-size: 3.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .glossary-subtitle {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 500;
    }

    .filter-section {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.05) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        padding: 30px;
        margin-bottom: 40px;
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .filter-form {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-input {
        flex: 1;
        min-width: 300px;
        padding: 16px 24px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.3);
        border-radius: 15px;
        font-size: 1rem;
        color: white;
        transition: all 0.3s ease;
    }

    .filter-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .filter-input:focus {
        outline: none;
        border-color: #4facfe;
        background: rgba(0, 0, 0, 0.5);
        box-shadow: 0 0 20px rgba(79, 172, 254, 0.3);
    }

    .filter-select {
        min-width: 250px;
        padding: 16px 24px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.3);
        border-radius: 15px;
        font-size: 1rem;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .filter-select option {
        background: #1a1a2e;
        color: white;
    }

    .filter-select:focus {
        outline: none;
        border-color: #00f2fe;
        background: rgba(0, 0, 0, 0.5);
        box-shadow: 0 0 20px rgba(0, 242, 254, 0.3);
    }

    .filter-btn {
        padding: 16px 40px;
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border: none;
        border-radius: 15px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
    }

    .filter-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(79, 172, 254, 0.6);
    }

    .empty-state {
        text-align: center;
        padding: 100px 20px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.05) 0%, rgba(255, 255, 255, 0.02) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 25px;
        animation: scaleIn 0.5s ease;
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .empty-icon {
        font-size: 6rem;
        color: #4facfe;
        margin-bottom: 30px;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    .empty-title {
        font-size: 2rem;
        font-weight: 700;
        color: white;
        margin-bottom: 15px;
    }

    .empty-text {
        color: rgba(255, 255, 255, 0.6);
        font-size: 1.1rem;
    }

    .glossary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        animation: fadeInUp 0.8s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .word-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.03) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .word-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .word-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        border-color: rgba(79, 172, 254, 0.5);
    }

    .word-card:hover::before {
        transform: scaleX(1);
    }

    .word-spanish {
        font-size: 1.8rem;
        font-weight: 800;
        color: #4facfe;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .word-spanish i {
        font-size: 1.5rem;
    }

    .word-euskera {
        font-size: 1.4rem;
        font-weight: 700;
        color: #00f2fe;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .word-euskera i {
        font-size: 1.2rem;
    }

    .word-definition {
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.7;
        font-size: 1rem;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    @media (max-width: 768px) {
        .glossary-title {
            font-size: 2.5rem;
        }

        .filter-form {
            flex-direction: column;
        }

        .filter-input,
        .filter-select,
        .filter-btn {
            width: 100%;
            min-width: auto;
        }

        .glossary-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="glossary-container">
    <div class="glossary-header">
        <h1 class="glossary-title">
            📚 Glosario Técnico
        </h1>
        <p class="glossary-subtitle">Explora y aprende vocabulario técnico en euskera</p>
    </div>

    <div class="filter-section">
        <form id="filtroGlosario" method="GET" action="./controllers/obtenerGlosario_controller.php" class="filter-form">
            <input type="text" 
                   name="buscar" 
                   id="buscar" 
                   class="filter-input"
                   placeholder="🔍 Buscar palabra...">

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
        <div class="glossary-grid" id="glossaryGrid">
            <?php foreach ($glosario as $d): ?>
                <div class="word-card">
                    <div class="word-spanish">
                        <i class="bi bi-translate"></i>
                        <?= htmlspecialchars($d['cast']) ?>
                    </div>
                    <div class="word-euskera">
                        <i class="bi bi-chat-quote"></i>
                        <?= htmlspecialchars($d['eusk']) ?>
                    </div>
                    <div class="word-definition">
                        <?= htmlspecialchars($d['definicion']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buscarInput = document.getElementById('buscar');
    const glossaryGrid = document.getElementById('glossaryGrid');
    const wordCards = glossaryGrid ? glossaryGrid.getElementsByClassName('word-card') : [];
    const ramaSelect = document.getElementById('rama');

    if (buscarInput && wordCards.length > 0) {
        buscarInput.addEventListener('input', () => {
            const filtro = buscarInput.value.toLowerCase();
            
            for (let i = 0; i < wordCards.length; i++) {
                const card = wordCards[i];
                const texto = card.textContent.toLowerCase();
                
                if (texto.includes(filtro)) {
                    card.style.display = '';
                    card.style.animation = 'fadeIn 0.3s ease';
                } else {
                    card.style.display = 'none';
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

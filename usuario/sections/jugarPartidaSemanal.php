<?php
$palabra = $_SESSION['palabra'] ?? null;

if (!$palabra) {
    echo "<div class='error-state'>
            <div class='error-glow'></div>
            <div class='error-icon'>❌</div>
            <h3>No se encontró ninguna palabra</h3>
            <a href='./index.php?section=juegos' class='btn-error'>Volver a Juegos</a>
          </div>";
    exit;
}
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">

</style>

<div class="weekly-game-container">
    <div class="weekly-card">
        <div class="weekly-header">
            <div class="weekly-badge">
                <i class="bi bi-trophy-fill"></i>
                <span>Partida de Repaso</span>
            </div>

        
        </div>

        <div class="definition-container">
            <div class="definition-label">
                <i class="bi bi-book-fill"></i>
                <span>Definición</span>
            </div>
            <div class="definition-text">
                <?= htmlspecialchars($palabra['definicion']) ?>
            </div>
        </div>

        <form action="./controllers/PartidaSemanal_controller.php?action=verificar" method="POST">
            <input type="hidden" name="id" value="<?= $palabra['id'] ?>">

            <div class="options-grid">
                <?php
                    $opciones = [
                        1 => $palabra['eusk1'],
                        2 => $palabra['eusk2'],
                        3 => $palabra['eusk3']
                    ];
                    asort($opciones);
                    $letras = ['A', 'B', 'C'];
                    $index = 0;
                    foreach ($opciones as $key => $value):
                ?>
                    <div class="option-wrapper">
                        <input type="radio" 
                               name="opcion" 
                               id="op<?= $key ?>" 
                               value="<?= $key ?>" 
                               class="option-input" 
                               required>
                        <label for="op<?= $key ?>" class="option-label">
                            <div class="option-letter"><?= $letras[$index] ?></div>
                            <div class="option-radio"></div>
                            <div class="option-text"><?= htmlspecialchars($value) ?></div>
                        </label>
                    </div>
                <?php 
                    $index++;
                    endforeach; 
                ?>
            </div>

            <button type="submit" class="submit-btn">
                <i class="bi bi-check-circle-fill"></i>
                <span>Enviar Respuesta</span>
            </button>
        </form>
    </div>
</div>

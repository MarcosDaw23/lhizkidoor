<?php
session_start();

// opcional: proteger si no hay usuario en sesión
if (!isset($_SESSION['user'])) {
    // redirigir al login o manejar el caso
    header('Location: /login.php');
    exit;
}
// Cargar el modelo una sola vez aquí
require_once "../models/AccesoBD_class.php";
$bd = new AccesoBD_Usuario();

// Obtener el nombre del centro (adaptamos si el método devuelve array)
$centroId = $_SESSION['user']['centro'];
$centroData = $bd->obtenerCentroById($centroId);

// Si obtenerCentroById devuelve un array con 'nombre', ajustamos:
if (is_array($centroData)) {
    $nombreCentro = $centroData['nombre'] ?? 'Desconocido';
} else {
    // si devuelve directamente el nombre
    $nombreCentro = $centroData ?? 'Desconocido';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { font-family: Poppins, sans-serif; background: #f0f0f0; padding: 6em; }
        .ranking-container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        select { padding: 8px 12px; font-size: 16px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #333; color: white; }

        .alert {
            position: fixed;
            top: 70px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            max-width: 600px;
            z-index: 2000;
            text-align: center;
            font-size: 1.05rem;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">LHizki</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarCollapse"
          aria-controls="navbarCollapse"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
         <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav me-auto mb-2 mb-md-0">
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] == 3): ?>
              <li class="nav-item">
                <a class="nav-link btn btn-warning text-blue" href="../controllers/obtenerGlosario_controller.php">Ver glosario</a>
              </li>
               <li class="nav-item">
                <a class="nav-link btn btn-warning text-blue" href="../index.php?section=juegos">Juegos</a>
              </li>
               <li class="nav-item">
                <a class="nav-link btn btn-warning text-blue" href="../sections/rankings.php">Ranking</a>
              </li>
            <?php endif; ?>

            <?php if (isset($_SESSION['user'])){ ?>
            <a href="../index.php?s=ajustes" class="btn btn-secondary">
              <i class="bi bi-gear"></i> 
            </a>
            <?php }?>
          </form>
        </div>

        <div class="collapse navbar-collapse" id="navbarCollapse">
        </div>
      </div>
    </nav>
<div class="ranking-container">
    <h2>Ranking - <?= htmlspecialchars($nombreCentro, ENT_QUOTES, 'UTF-8') ?></h2>
    <label for="categoria">Selecciona categoría:</label>
    <select id="categoria" onchange="cambiarRanking()">
        <option value="ramas">Familia</option>
        <option value="sectores">Grado</option>
        <option value="clases">Clases</option>
        <option value="individual">Individual</option>
    </select>

    <div id="ranking-table">
        <?php
        require_once "../models/AccesoBD_class.php";
        $bd = new AccesoBD_Usuario();
        $categoria = 'ramas';
        $id = $_SESSION['user']['id'];
        $centro = $_SESSION['user']['centro'];
        $clase = $_SESSION['user']['clase'];
        $sector = $_SESSION['user']['sector'];


        function renderTabla($datos, $columnas) {
            echo "<table><thead><tr>";
            foreach ($columnas as $col) {
                echo "<th>$col</th>";
            }
            echo "</tr></thead><tbody>";
            foreach ($datos as $fila) {
                echo "<tr>";
                foreach ($fila as $valor) {
                    echo "<td>$valor</td>";
                }
                echo "</tr>";
            }
            echo "</tbody></table>";
        }
        $datos = $bd->obtenerRankingRamas($centro);
        renderTabla($datos, ['Rama', 'Puntuación']);
        ?>
    </div>
</div>

<script>
function cambiarRanking() {
    const categoria = document.getElementById('categoria').value;
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'ranking_ajax.php?categoria=' + categoria, true);
    xhr.onload = function() {
        if (this.status === 200) {
            document.getElementById('ranking-table').innerHTML = this.responseText;
        }
    };
    xhr.send();
}
</script>

</body>
</html>
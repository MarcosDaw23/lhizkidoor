<?php
// ... (Tu código PHP de la parte superior sigue igual)
require_once __DIR__ . '/../models/AccesoBD_class.php';

// Asegúrate de que la sesión esté iniciada si vas a acceder a $_SESSION
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$bd = new AccesoBD_Usuario();

// 🔹 Usar la variable correcta de sesión
$usuarioId = $_SESSION['user']['id'] ?? 0;

if (!$usuarioId) {
    header("Location: ../index.php?section=login");
    exit;
}

// Obtener rama y palabra (tal como en el código original)
$rama = $bd->obtenerIdRamaPorSector($_SESSION['user']['sector'] ?? '');
$palabra = $bd->obtenerPalabraTraduccionPorUsuario($rama);

// Verifica si no hay palabras disponibles
$no_palabra = (!$palabra);

if ($no_palabra) {
    // Si no hay palabras, usamos el HTML de felicitación
    $palabra = ['eusk' => '', 'id' => 0, 'definicion' => '']; // Valores por defecto para evitar errores
}
?>

<link rel="stylesheet" href="./css/sectionsfinal.css">
    <div class="container">
        <div class="row justify-content-center">
            
            <div class="col-lg-6 col-md-8 col-sm-10 col-11">
                    <div class="glass-effect text-white p-3 p-sm-4 p-md-5">
                        
                        <div class="text-center">
                            <p class="text-light-50 text-uppercase small fw-bold" style="letter-spacing: 1px;">
                                TRADUCE DEL EUSKERA AL CASTELLANO
                            </p>
                            
                            <div class="word-display my-4">
                                <h1 class="display-3 fw-bold my-0 text-white-full" id="palabra-eusk">
                                    <?= htmlspecialchars($palabra['eusk']); ?>
                                </h1>
                            </div>
                        </div>

                        <form id="formTraduccion" method="POST" action="./controllers/traduccion_controller.php">
                            <input type="hidden" name="id_palabra" value="<?= htmlspecialchars($palabra['id']); ?>">

                            <div class="mb-3">
                                <label for="respuestaInput" class="form-label text-light-75">
                                    Escribe la traducción en castellano:
                                </label>
                                <input type="text" name="respuesta" id="respuestaInput"
                                       class="form-control form-control-lg form-control-glass text-center py-2"
                                       placeholder="Tu respuesta aquí..." required autocomplete="off" autofocus>
                            </div>

                           <button type="submit" class="submit-button">
                              <i class="bi bi-arrow-right-circle-fill"></i>
                              <span>Comprobar</span>
                          </button>
                        </form>

                        <hr style="border-color: rgba(255,255,255,0.2);" class="my-4">

                        <p class="text-center text-light-75 mb-0 small">
                            <i class="bi bi-lightbulb-fill text-warning"></i> 
                            <strong  style="color: #4facfe;">Pista:</strong> <?= htmlspecialchars($palabra['definicion']); ?>
                        </p>

                    </div> 
            </div>
        </div>
    </div>
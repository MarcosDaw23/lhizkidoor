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

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    
    body, .btn, .form-control {
        font-family: 'Poppins', sans-serif;
    }



    .glass-effect {
        background: rgba(255, 255, 255, 0.15); 
        backdrop-filter: blur(12px); 
        -webkit-backdrop-filter: blur(12px); 
        border: 1px solid rgba(255, 255, 255, 0.2); 
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        border-radius: 1.25rem;
    }


    .form-control-glass {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white; 
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    .form-control-glass::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }
    .form-control-glass:focus {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.5);
        box-shadow: none;
        color: white;
    }
.submit-button {
        width: 100%;
        padding: 22px;
        background: linear-gradient(135deg, #ff6b6b 0%, #4facfe 100%);
        color: white;
        border: none;
        border-radius: 20px;
        font-size: 1.3rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        box-shadow: 0 15px 40px rgba(255, 107, 107, 0.4);
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .submit-button::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.6s ease, height 0.6s ease;
    }

    .submit-button:hover::before {
        width: 400px;
        height: 400px;
    }

    .submit-button:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(255, 107, 107, 0.6);
    }


    .text-light-50 {
        color: rgba(255, 255, 255, 0.5) !important;
    }
    .text-light-75 {
        color: rgba(255, 255, 255, 0.75) !important;
    }
    .text-white-full {
        color: white !important;
    }
    .word-display {
        background: rgba(255, 255, 255, 0.1);
        padding: 1rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    @media (max-width: 576px) {
        #palabra-eusk {
            font-size: 3.25rem;
            line-height: 1.2;
        }
        .container{
          margin-top:60px
        }
      
    }
</style>
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
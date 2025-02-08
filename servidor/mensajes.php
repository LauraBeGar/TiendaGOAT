<?php
function mostrarMensaje() {
    // Capturar los parámetros de la URL
    $error = $_GET['error'] ?? null;
    $mensaje = $_GET['mensaje'] ?? null;

    if ($error): 
        echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
    endif; 

    if ($mensaje): 
        echo '<div class="alert alert-success">' . htmlspecialchars($mensaje) . '</div>';
    endif;
}
?>

<?php
session_start();
require_once 'config.php';

require_once '../gestores/GestorUsuarios.php';

$db = conectar();

// Capturar los valores del formulario
$email = htmlspecialchars(trim($_POST['email']));
$clave = htmlspecialchars(trim($_POST['clave']));

// Crea objeto de la clase GestorUsuarios
$gestor = new GestorUsuarios($db);

// Verifica las credenciales del usuario
$usuario = $gestor->login($email, $clave);

if ($usuario) {
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['rol'] = $usuario['rol'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['dni'] = $usuario['dni'];

    // Redirige al panel correspondiente según el rol
    if ($usuario['rol'] == 0) {
        header('Location: ../paginas/panel_usuario.php');
    } elseif ($usuario['rol'] == 1) {
        header('Location: ../paginas/panel_administrador.php');
    } elseif ($usuario['rol'] == 2) {
        header('Location: ../paginas/panel_editor.php');
    }
    exit();
} else {
    header('Location: ../paginas/login.php?error=Email o clave incorrectos');
    exit();
}
?>
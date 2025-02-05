<?php
session_start();

include '../gestores/GestorUsuarios.php';
include 'config.php';

if (!isset($_SESSION['email_recuperar']) || !isset($_SESSION['dni_recuperar'])) {
    header("Location: ../paginas/restablecer_clave.php?error=Acción no permitida");
    exit();
}

$encontrado = isset($_GET['encontrado']) && $_GET['encontrado'] == 'true';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_SESSION['email_recuperar'];
    $dni = trim($_POST['dni_recuperar']);
    $clave = trim($_POST['clave']);

    if (strlen($clave) < 8 || strlen($clave) > 20 || !preg_match('/[a-zA-Z]/', $clave)) {
        header("Location: ../paginas/restablecer_clave.php?error=La contraseña debe tener entre 8 y 20 caracteres y al menos una letra.");
        exit();
    }

    $db = conectar();
    
    $gestor = new GestorUsuarios($db);
    if ($gestor->restablecerClave($email, $clave)) {
        header('Location: ../paginas/login.php?mensaje=Contraseña restablecida con éxito');
        exit();
    } else {
        header('Location: ../paginas/login.php?error=no se ha podido restablecer la contraseña');
        exit();
    }

    // Limpiar la sesión de recuperación
    unset($_SESSION['email_recuperar']);
    unset($_SESSION['dni_recuperar']);
}
?>

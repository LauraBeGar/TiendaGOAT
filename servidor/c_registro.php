<?php
session_start();

include_once 'config.php';
include_once '../gestores/GestorUsuarios.php';
require_once '../gestores/Usuario.php';

$db = conectar();

$dni = htmlspecialchars(trim($_POST['dni']));
$nombre = htmlspecialchars(trim($_POST['nombre']));
$apellidos = htmlspecialchars(trim($_POST['apellidos']));
$email = htmlspecialchars(trim($_POST['email']));
$clave = htmlspecialchars(trim($_POST['clave']));
$rol = 0;
$activo = 1;


//validar la contraseña
if (strlen($clave) < 8 || strlen($clave) > 20 || !preg_match('/[a-zA-Z]/', $clave)) {
    header("Location: ../paginas/registro.php?error=La contraseña debe tener entre 8 y 20 caracteres y al menos una letra.");
    exit();
}
$usuario = new Usuario($dni, $nombre, $apellidos, '', '', '', '', $email, $rol, $activo, $clave);

$gestor = new GestorUsuarios($db);


$resultado = $gestor->registrar_usuario($usuario);

if ($resultado === true) {
    header('Location:../paginas/login.php?mensaje=Registro exitoso');
    exit();
} else {
    header('Location:../paginas/registro.php?error=Error al registrar el usuario');
    exit();
}
?>

<?php
session_start();

//TERMINAR
if ((isset($_POST['dni']) && empty($_POST['dni'])) || (isset($_POST['email']) && empty($_POST['email'])) || (isset($_POST['nombre']) && empty($_POST['nombre']))
|| (isset($_POST['apellidos']) && empty($_POST['apellidos']))|| (isset($_POST['direccion']) && empty($_POST['direccion']))|| (isset($_POST['localidad']) && empty($_POST['localidad']))
|| (isset($_POST['provincia']) && empty($_POST['provincia']))|| (isset($_POST['telefono']) && empty($_POST['telefono']))) {
    header('Location: ../paginas/usuario_checkout.php?error= Faltan datos por rellenar');
    exit();
}


require_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';
include_once '../gestores/Usuario.php';
require_once '../servidor/seguridadUsuario.php';


$db = conectar();
$gestor = new GestorUsuarios($db);

$dni = $_POST['dni'];
$email = $_POST['email'];
$nombre = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$direccion = $_POST['direccion'];
$localidad = $_POST['localidad'];
$provincia = $_POST['provincia'];
$telefono = $_POST['telefono'];

// Llama al gestor para actualizar los datos del usuario en la base de datos
$actualizado = $gestor->completarInfo($dni, $direccion, $localidad, $provincia, $telefono);

if ($actualizado) {
    // Mensaje de éxito
    header('Location: /paginas/paypal.php?mensaje= informacion completada');
    exit();
} else {
    header('Location: /paginas/checkout.php?error=Error al completar los datos');
    exit();
}

?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: ../paginas/login.php');
    exit();
}
//TERMINAR
if ((isset($_POST['dni']) && empty($_POST['dni'])) || (isset($_POST['email']) && empty($_POST['email'])) || (isset($_POST['nombre']) && empty($_POST['nombre']))) {
    header('Location: usuario_checkout.php?faltan datos por rellenar');
}


require_once '../servidor/config.php';
require_once '../gestores/GestorUsuarios.php';
require_once '../gestores/Usuario.php';

// Conexión a la base de datos
$db = conectar();
$gestor = new GestorUsuarios($db);


// Obtén los valores del formulario
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
<?php

require_once 'config.php'; 
require_once '../gestores/GestorUsuarios.php';
require_once '../gestores/Usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $direccion = $_POST['direccion'];
    $localidad = $_POST['localidad'];
    $provincia = $_POST['provincia'];
    $telefono = $_POST['telefono'];
    $rol = isset($_POST['rol']) ? $_POST['rol'] : 0;
    $estado = isset($_POST['activo']) ? $_POST['activo'] : 1;
    $clave = $_POST['clave'];

    
    $claveHasheada = password_hash($clave, PASSWORD_BCRYPT);

    
    $usuario = new Usuario(
        $dni,
        $nombre,
        $apellidos,
        $direccion,
        $localidad,
        $provincia,
        $telefono,
        $email,
        $rol,
        $estado,
        $claveHasheada, 
    );
    $db = conectar();
    $gestorUsuarios = new GestorUsuarios($db);

    if ($gestorUsuarios->crear_usuario($usuario)) {
        header('Location: ../paginas/gestion_usuarios.php?mensaje=Usuario creado correctamente');
    } else {
        header('Location: ../paginas/crear_usuario.php?error=No se pudo crear el usuario');
    }

} else {
    header('Location: ../paginas/crear_usuario.php?error=Acceso no permitido');
    exit();
}

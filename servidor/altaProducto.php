<?php
session_start();

if (!isset($_SESSION['email']) || ($_SESSION['rol'] !== 1 && $_SESSION['rol'] !== 2)) {
    header("Location:logout.php");
    exit();
}

include_once '../gestores/Producto.php';
include_once '../gestores/GestorProductos.php';
include_once 'config.php';

$db = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validación del código de producto:
    if (!preg_match('/^[A-Za-z]{3}[0-9]{1,5}$/', $_POST['codigo'])) {
        header("Location: ../paginas/alta_producto.php?error=Código inválido");
        exit();
    }

    // Verifico los campos obligatorios:
    if (empty($_POST['codigo']) || empty($_POST['nombre']) || empty($_POST['descripcion']) 
        || empty($_POST['categoria']) || empty($_POST['precio']) || !isset($_FILES['imagen']) || !isset($_POST['activo'])) {
        header("Location: ../paginas/alta_producto.php?error=No has introducido los datos");
        exit();
    }

    // Validación de que precio no pueda ser negativo:
    if ($_POST['precio'] < 0) {
        header("Location: ../paginas/alta_producto.php?error=El precio no puede ser negativo");
        exit();
    }

    // Manejo la subida de la imagen:
    
    $nombreImagen = basename($_FILES["imagen"]["name"]);
    $rutaImagen = "../img/" . $nombreImagen;
    $tipoArchivo = strtolower(pathinfo($rutaImagen, PATHINFO_EXTENSION));

    // Verifico si el archivo es una imagen:
    $comprobacion = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($comprobacion === false) {
        header("Location: ../paginas/alta_producto.php?error=El archivo no es una imagen");
        exit();
    }

    // Verifico el tamaño del archivo:
    if ($_FILES["imagen"]["size"] > 300000) {
        header("Location: ../paginas/alta_producto.php?error=El archivo es demasiado grande");
        exit();
    }

    // Verifico la dimensión del archivo:
    if ($comprobacion[0] > 500 || $comprobacion[1] > 500) {
        header("Location: ../paginas/alta_producto.php?error=La imagen es demasiado grande");
        exit();
    }

    // Solo puedo usar formato jpeg, jpg, png o gif:
    if ($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif") {
        header("Location: ../paginas/alta_producto.php?error=Formato de imagen no válido");
        exit();
    }

    // Manejo la subida del archivo:
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen)) {
        header("Location: ../paginas/alta_producto.php?error=Error al subir la imagen");
        exit();
    }
    

    // Crear el objeto Articulo con la ruta de la imagen en la base de datos
    $producto = new Producto(
        $_POST['codigo'], 
        $_POST['nombre'], 
        $_POST['descripcion'], 
        $nombreImagen,
        $_POST['categoria'],
        $_POST['precio'],
        (isset($_POST['activo']) ? 1 : 0),
  

    );

    $gestor = new GestorProductos($db);

    $result = $gestor->registrar($producto);

    if ($result) {
        header('Location: ../paginas/gestion_productos.php?mensaje=Articulo registrado correctamente');
        exit();
    } else {
        header('Location: ../paginas/gestion_productos.php?error=Error al registrar el producto');
        exit();
    }
}
?>
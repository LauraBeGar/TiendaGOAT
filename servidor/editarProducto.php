<?php
session_start();

if (!isset($_SESSION["email"])) {
    header('Location: ../index.php');
    exit();
}

if (
    isset($_POST['codigo']) &&
    isset($_POST['nombre']) &&
    isset($_POST['descripcion']) &&
    isset($_POST['categoria']) &&
    isset($_POST['precio']) &&
    isset($_POST['activo'])
) {
    require_once 'config.php';
    require_once '../gestores/Producto.php';
    require_once '../gestores/GestorProductos.php';

    $rol = $_SESSION['rol'];
    $db = conectar();
    $gestor = new GestorProductos($db);

    // Obtener el producto actual
    $productoActual = $gestor->getProductoPorCodigo($_POST['codigo']);

    if (!$productoActual) {
        header("Location: ../paginas/editar_producto.php?error=Producto no encontrado");
        exit();
    }

    $codigo = htmlspecialchars(trim($_POST['codigo']));
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $descripcion = htmlspecialchars(trim($_POST['descripcion']));
    $categoria = htmlspecialchars(trim($_POST['categoria']));
    $precio = floatval($_POST['precio']);
    $activo = intval($_POST['activo']);

    // Validación del código de producto
    if (!preg_match('/^[A-Za-z]{3}[0-9]{1,5}$/', $codigo)) {
        header("Location: ../paginas/editar_producto.php?codigo=" . $productoActual->getCodigo() . "&error=Código inválido");
        exit();
    }

    // Validación de precio negativo
    if ($precio < 0) {
        header("Location: ../paginas/editar_producto.php?codigo=" . $productoActual->getCodigo() . "&error=El precio no puede ser negativo");
        exit();
    }

    // Mantener la imagen existente por defecto
    $nombreImagen = $productoActual['imagen'];

    // Manejo de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreImagen = basename($_FILES["imagen"]["name"]);
        $rutaImagen = "img/" . $nombreImagen;
        $tipoArchivo = strtolower(pathinfo($rutaImagen, PATHINFO_EXTENSION));

        // Verifico si el archivo es una imagen:
        $comprobacion = getimagesize($_FILES["imagen"]["tmp_name"]);
        if ($comprobacion === false) {
            header("Location: ../paginas/editar_producto.php?codigo=" . $codigo . "&error=El archivo no es una imagen");
            exit();
        }

        // Verifico el tamaño del archivo:
        if ($_FILES["imagen"]["size"] > 300000) {
            header("Location: ../paginas/editar_producto.php?codigo=" . $codigo . "&error=El archivo es demasiado grande");
            exit();
        }

        // Verifico la dimensión del archivo:
        if ($comprobacion[0] > 500 || $comprobacion[1] > 500) {
            header("Location: ../paginas/editar_producto.php?codigo=" . $codigo . "&error=La imagen es demasiado grande");
            exit();
        }

        // Solo puedo usar formato jpeg, jpg, png o gif:
        if ($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg" && $tipoArchivo != "gif") {
            header("Location: ../paginas/editar_producto.php?codigo=" . $codigo . "&error=Formato de imagen no válido");
            exit();
        }

        // Manejo la subida del archivo:
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen)) {
            header("Location: ../paginas/editar_producto.php?codigo=" . $codigo . "&error=Error al subir la imagen");
            exit();
        }

        // Guardar la ruta completa en la base de datos
        $nombreImagen = $rutaImagen;
    }

    // Validar permisos de modificación de código
    if ($rol != 1 && $codigo !== $productoActual->getCodigo()) {
        header("Location: ../paginas/editar_producto.php?codigo=" . $productoActual->getCodigo() . "&error=No tiene permisos para modificar el código");
        exit();
    }

    $productoEditado = new Producto(
        $codigo,
        $nombre,
        $descripcion,
        $nombreImagen,
        $categoria,
        $precio,
        $activo
    );

    $resultado = $gestor->editar($productoEditado);

    if ($resultado) {
        header('Location: ../paginas/gestion_productos.php?mensaje=El producto se ha modificado con éxito');
        exit();
    } else {
        header('Location: ../paginas/gestion_productos.php?error=Error al editar el producto');
        exit();
    }
}
?>

<?php
session_start();

require_once '../servidor/config.php';
require_once '../gestores/GestorProductos.php';
require_once '../gestores/Producto.php';

require '../servidor/seguridad.php';

$codigo = htmlspecialchars(trim($_GET['codigo']));

$db = conectar();

$gestor = new GestorProductos($db);

$producto = $gestor->getProductoPorCodigo($codigo);

if (!$producto) {
    header("Location: gestion_productos.php?mensaje=Producto no encontrado");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($gestor->bajaProducto($codigo)) {
        header("Location: gestion_productos.php?mensaje=Producto dado de baja con éxito");
    } else {
        header("Location: gestion_productos.php?mensaje=Error al dar de baja el producto");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Baja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <?php include '../plantillas/menuAdmin.php' ?>
    <div class="container mt-5">
        <h2 class="text-center">Confirmar Baja</h2>
        <p class="text-center">¿Estás seguro de que deseas dar de baja el producto <strong><?php echo htmlspecialchars($producto['codigo']); ?></strong>?</p>

        <form method="POST" class="text-center">
            <button type="submit" class="btn btn-danger">Sí, dar de baja</button>
            <a href="gestion_productos.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../plantillas/footer.php' ?>
</body>

</html>
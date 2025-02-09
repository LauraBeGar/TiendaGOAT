<?php
session_start();

require_once '../servidor/config.php';
require_once '../gestores/GestorProductos.php';

$db = conectar();
$gestor = new GestorProductos($db);

$codigo = $_GET['codigo'] ?? null;

if (!$codigo) {
    header('Location: index.php');
    exit();
}

$producto = $gestor->getProductoPorCodigo($codigo);

if (!$producto) {
    header('Location: index.php?error=producto_no_encontrado');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($producto['nombre']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include '../plantillas/header.php'; ?>
    <?php
    include '../plantillas/menuAdmin.php';
    include '../plantillas/menuEditor.php';
    ?>

    <div class="container-fluid mt-4 flex-grow-1 ">
        <div class="row">

            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>
            <div class="col-md-8 ">
                <div class="row g-4 ms-5">
                    <div class="col-md-4">
                        <img src="/img/<?= htmlspecialchars($producto['imagen']) ?>" class="img-fluid rounded-start"
                            alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($producto['nombre']) ?></h5>
                            <p class="card-text"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
                            <h4 class="text-primary">€<?= number_format($producto['precio'], 2) ?></h4>
                            <a href="/servidor/c_carrito.php?codigo=<?= $producto['codigo'] ?>&nombre=<?= $producto['nombre'] ?>&imagen=<?= $producto['imagen'] ?>&precio=<?= $producto['precio'] ?>&categoria=<?= $producto['categoria'] ?>"
                                class="btn btn-outline-success text-dark">Añadir al carrito</a>
                            <a href="productos.php?catProds=<?= $producto['categoria'] ?>"
                                class="btn btn-outline-warning text-dark">Volver a la lista</a>
                        </div>
                    </div>
                </div>

            </div>
            <?php include '../plantillas/menuUsuario.php'; ?>
        </div>
    </div>
    <?php include '../plantillas/footer.php'; ?>
</body>

</html>
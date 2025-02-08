<?php
include_once '../servidor/mensajes.php';

session_start();
$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include_once '../plantillas/header.php' ?>
    <?php
    include '../plantillas/menuAdmin.php';
    include '../plantillas/menuEditor.php';
    ?>

    <div class="container-fluid mt-4 flex-grow-1">
        <div class="row ">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>

            <div class="col-md-8 text-center">
                <h1 class="mb-4">Carrito de Compras</h1>
                <?php mostrarMensaje() ?>
                <?php if (empty($carrito)): ?>
                    <p>No tienes productos en tu carrito.</p>
                <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($carrito as $producto): ?>
                                <tr>
                                    <td><?= $producto['nombre'] ?></td>
                                    <td><?= $producto['cantidad'] ?></td>
                                    <td><?= number_format($producto['precio'], 2) ?> €</td>
                                    <td><?= number_format($producto['precio'] * $producto['cantidad'], 2) ?> €</td>
                                    <td>
                                        <a href="/servidor/eliminarProdCarrito.php?codigo=<?= $producto['codigo'] ?>&cantidad=<?= $producto['cantidad'] ?>"
                                            class="btn btn-danger">Eliminar</a>
                                    </td>
                                </tr>
                                <?php
                                $total += $producto['precio'] * $producto['cantidad'];
                                ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                        <div class="d-flex justify-content-end">
                            <h3>Total: <?= number_format($total, 2) ?> €</h3>
                        </div>

                        <div class="d-flex justify-content-end mt-3 mb-5">
                            <a href="usuario_checkout.php" class="btn btn-success">Proceder al pago</a>
                        </div>
                    <?php endif; ?>

            </div>
            <?php include '../plantillas/menuUsuario.php' ?>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
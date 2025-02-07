<?php
session_start();

require_once '../servidor/config.php';
require_once '../gestores/GestorPedidos.php';


include_once '../gestores/Pedido.php';

$db = conectar();

$gestor = new GestorPedidos($db);
$idPedido = $_GET['idPedido'];
$resultado = $gestor->obtenerPedido($idPedido);
$productosPedido = $gestor->obtenerLineasPedidos($idPedido);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include_once '../plantillas/header.php' ?>

    <div class="container-fluid mt-4 flex-grow-1">
        <div class="row ">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>

            <div class="col-md-8 text-center">
                <h1 class="mb-4">Pedido<?= $idPedido ?></h1>

                <div class="row">
                    <div class="col">
                    <strong>Fecha: </strong><?= $resultado['fecha'] ?>
                    </div>
                    <div class="col">
                    <strong>Total: </strong><?= $resultado['total'] ?>€
                    </div>
                    <div class="col">
                    <strong>Estado: </strong><?= $resultado['estado'] ?>
                    </div>

                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach ($productosPedido as $producto) { ?>
                            <tr>

                                <td><?= $producto['nombre_producto'] ?></td>
                                <td><?= $producto['cantidad'] ?></td>
                                <td><?= number_format($producto['precio'], 2) ?> €</td>
                                <td><?= number_format($producto['precio'] * $producto['cantidad'], 2) ?> €</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include_once '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
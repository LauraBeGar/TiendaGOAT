<?php
session_start();

require_once '../servidor/config.php';
require_once '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridadUsuario.php';

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include '../plantillas/header.php' ?>
    <?php
    include '../plantillas/menuAdmin.php';
    include '../plantillas/menuEditor.php';
    ?>
    
    <div class="container-fluid mt-4 flex-grow-1 d-flex flex-column justify-content-center">
        <div class="row ">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>

            <div class="col-md-8 text-center">
                <h1 class="mb-4">Pedido <?= $idPedido ?></h1>
                <?php mostrarMensaje() ?>
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
                <div class="row mt-5 mb-5">
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
            </div>
            <?php include '../plantillas/menuUsuario.php' ?>
        </div>
    </div>
    
    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
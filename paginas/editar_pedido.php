<?php
session_start();

include '../servidor/config.php';
include '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';

$db = conectar();

$gestor = new GestorPedidos($db);
$idPedido = $_GET['idPedido'];
$resultado = $gestor->obtenerPedido($idPedido);

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda GOAT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <?php if ($_SESSION['rol'] == 1) {
        include '../plantillas/menuAdmin.php';
    } elseif ($_SESSION['rol'] == 2) {
        include '../plantillas/menuEditor.php';

    }
    ?>

    <div class="container my-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center mt-3 mb-4">Pedido <?= $idPedido ?></h1>
            </div>
            <div class="col">
                Estado: <?= $resultado["estado"] ?>
            </div>
        </div>

        <div class="row">
            <div class="row">
                <h3>Cambiar estado</h3>
            </div>
            <div class="row">
                <?php if($resultado["estado"] == "Entregado" || $resultado["estado"] == "Cancelado"){  ?>
                    Este pedido está <?= $resultado["estado"] ?>
                    <?php }else{ ?>
                <div class="col">
                    <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Proceso">Proceso</a>
                </div>
                <div class="col">
                    <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Preparando">Preparando</a>
                </div>
                <div class="col">
                    <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Enviado">Enviado</a>
                </div>
                <div class="col">
                    <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Entregado">Entregado</a>
                </div>
                <?php } ?>
            </div>
        </div>


    </div>


    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
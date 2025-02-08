<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';
require_once '../servidor/seguridad.php';

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
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include '../plantillas/header.php' ?>
    <?php
    include '../plantillas/menuAdmin.php';
    include '../plantillas/menuEditor.php';
    ?>
 <div class="container-fluid mt-4 flex-grow-1 d-flex flex-column align-items-center">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Pedido <?= $idPedido ?></h1>
        <span class="badge bg-warning text-dark fs-6 px-3 py-2"><?= $resultado["estado"] ?></span>
    </div>

    <div class="text-center mb-4">
        <h3 class="fs-5">Cambiar estado</h3>
    </div>

    <?php if ($resultado["estado"] == "Entregado" || $resultado["estado"] == "Cancelado") { ?>
        <p class="text-danger fw-semibold text-center">Este pedido está <?= $resultado["estado"] ?></p>
    <?php } else { ?>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Proceso" class="btn btn-outline-warning text-dark">Proceso</a>
            <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Preparando" class="btn btn-outline-warning text-dark">Preparando</a>
            <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Enviado" class="btn btn-outline-warning text-dark">Enviado</a>
            <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Entregado" class="btn btn-outline-warning text-dark">Entregado</a>
        </div>
    <?php } ?>
</div>



    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
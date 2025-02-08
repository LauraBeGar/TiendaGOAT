<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';

$db = conectar();

$gestor = new GestorPedidos($db);
$idPedido = $_GET['idPedido'];
$resultado = $gestor->obtenerPedido($idPedido)

    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
    <title>Cancelar pedido</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include '../plantillas/header.php' ?>
    <?php
    include '../plantillas/menuAdmin.php';
    include '../plantillas/menuEditor.php';
    ?>
    
    <div class="container-fluid mt-4 flex-grow-1 d-flex flex-column justify-content-center">
        <h2 class="text-center mt-3">Confirmar Cancelación</h2>
        <div class="text-center text-danger mt-5">
            <?php if ($resultado['estado'] === 'Cancelado') { ?>
                <p>El pedido ya ha sido cancelado</p>
            <?php } else { ?>
                <p class="text-dark">¿Estás seguro de que deseas dar de baja el pedido <strong><?= $idPedido ?></strong>?</p>
                <div class="text-center">
                    <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Cancelado" class="btn btn-danger me-4">Sí, dar de baja</a>
                    <a href="pedido_usuario.php" class="btn btn-secondary">Cancelar</a>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>


</html>
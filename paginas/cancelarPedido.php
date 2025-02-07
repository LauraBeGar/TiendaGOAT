<?php
session_start();

include '../servidor/config.php';
include '../gestores/GestorPedidos.php';
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

    <link rel="stylesheet" href="../estilos/style1.css">
    <title>Cancelar pedido</title>
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <?php include '../plantillas/menuAdmin.php' ?>

    <div class="container mt-5">
        <h2 class="text-center">confirmar Cancelacion</h2>
        <?php if($resultado['estado']==='Cancelado'){?>
            <p>Pedido ya cancelado</p>
        <?php } else{ ?>
        <p class="text-center">¿Estás seguro de que deseas dar de baja el pedido <strong><?php $idPedido ?></strong>?</p>

            <a href="../servidor/cambiarEstado.php?pedido=<?= $idPedido ?>&estado=Cancelado" class="btn btn-danger">Sí, dar de baja</a>
            <a href="gestion_pedidos.php" class="btn btn-secondary">Cancelar</a>
            <?php }  ?>

    </div>
    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../plantillas/footer.php' ?>
</body>

</html>
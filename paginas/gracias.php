<?php
session_start();
require_once '../servidor/config.php';
include_once '../gestores/GestorPedidos.php';

$db = conectar();

$gestor = new GestorPedidos($db);
$cod_usuario = $_SESSION['dni'];
$pedidos = $gestor->obtenerPedidosUsuario($cod_usuario);

$ultimo_pedido = array_pop($pedidos); 
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body class="bg-light">
    <?php include '../plantillas/header.php' ?>

    <div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
        <div class="row w-100">
            <div class="col-md-8 col-lg-6 mx-auto bg-white p-5 rounded shadow-sm text-center">
                <h2 class="mb-4">¡Gracias por tu compra en Goat!</h2>
                <p class="lead mb-4">Tu número de pedido es: <strong><?php echo $ultimo_pedido->getidPedido(); ?></strong></p>
                <p class="mb-4">En breve recibirás un correo de confirmación.</p>
                
                <div>
                    <a href="../index.php" class="btn btn-primary-custom link-hover-custom">Volver al inicio</a>
                </div>
            </div>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

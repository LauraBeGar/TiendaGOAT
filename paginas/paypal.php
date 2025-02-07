<?php
session_start();

include_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';

// Verifica si el carrito está vacío, redirige si es necesario
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header('Location: carrito.php');
    exit();
}

$db = conectar();
$gestor = new GestorUsuarios($db);

$productos = $_SESSION['carrito'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="./estilos/style1.css">
    <script src="https://www.paypal.com/sdk/js?client-id=AZDVjHKXhhyyBowBuhZDWeXpb3i7erkmqjSnH20QQVweow5GsOEeOISBD-hlQXtHie2lhnGlWViQGexa&currency=EUR"></script>
</head>
<body class="d-flex flex-column min-vh-100"> <!-- Flexbox con altura mínima del 100% -->

<?php include '../plantillas/header.php' ?>

    <div class="container-fluid mt-4 flex-grow-1"> <!-- Flex-grow para que el contenido se expanda -->
        <div class="row">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>
            <div class="col-md-10">
                <h2 class="mb-4">Resumen de Pedido</h2>

                <!-- Resumen de productos -->
                <div class="mb-4">
                    <h5>Productos en el pedido</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto): 
                                $subtotal = $producto['cantidad'] * $producto['precio'];
                                $total += $subtotal;
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($producto['cantidad']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($producto['precio'], 2)); ?>€</td>
                                    <td><?php echo htmlspecialchars(number_format($subtotal, 2)); ?>€</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <th colspan="3" class="text-end">Total</th>
                                <th><?php echo htmlspecialchars(number_format($total, 2)); ?>€</th>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <a href="../servidor/registrarPedido.php" class="button">continuar</a> -->
                </div>

             
 <!-- Botón PayPal con SDK -->
 <div class="text-center">
                    <div id="paypal-button-container"></div>
                </div>

                <script>
                    paypal.Buttons({
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: '<?php echo number_format($total, 2); ?>' // El total del pedido
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                // Redirige a una página de éxito con los detalles de la transacción
                                fetch("../servidor/registrarPedido.php" )
                                .then(response => response.json())
                                .then(data => {
                                    window.location.href = data
                                })
                            });
                        },
                        onCancel: function(data) {
                            // Redirige a la página de cancelación
                            window.location.href = "cancelado.php";
                        }
                    }).render('#paypal-button-container');
                </script>
            </div>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

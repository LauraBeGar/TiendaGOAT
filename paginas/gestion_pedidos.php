<?php
session_start();

include '../servidor/config.php';
include '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';

$db = conectar();

$gestor = new GestorPedidos($db);

$pedidos = $gestor->listarPedidos();

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
<?php if ($_SESSION['rol']==1){
         include '../plantillas/menuAdmin.php';
    }elseif($_SESSION['rol']==2){
        include '../plantillas/menuEditor.php';

    }
      ?>

    <div class="container my-5">
        <h1 class="text-center mt-3 mb-4">Gestión de Pedidos</h1>

        <!-- Barra de opciones -->
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o codigo">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
            </form>
        </div>
        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Id Pedido</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Cod Usuario</th>
                        <th>Activo</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Dar de baja</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($pedidos as $pedido){?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido['idPedido']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($pedido['total'], 2)); ?>€</td>
                            <td><?php echo htmlspecialchars($pedido['estado'] == 1 ? 'Pendiente' : 'Completado'); ?></td>
                            <td><?php echo htmlspecialchars($pedido['cod_usuario']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['activo'] == 1 ? 'Activo' : 'Inactivo'); ?></td>
                            <td class="text-center">
                                <a href="editar_pedido.php?idPedido=<?php echo htmlspecialchars($pedido['idPedido']); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="baja_pedido.php?idPedido=<?php echo htmlspecialchars($pedido['idPedido']); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
    </div>


    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
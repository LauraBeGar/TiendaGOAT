<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';
include_once '../servidor/mensajes.php';
include_once '../servidor/seguridad.php';

$db = conectar();

$gestor = new GestorPedidos($db);

// Paginación
$pedidosPorPagina = 5;

// Obtener número de página actual 
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina < 1)
    $pagina = 1; 

// Índice de inicio, primer artículo que se mostrará en la página 
$inicio = ($pagina - 1) * $pedidosPorPagina;

// Obtener pedidos paginados
$pedidos = $gestor->getPedidosPag($inicio, $pedidosPorPagina);  // Asegúrate de que $pedidos reciba los resultados de la paginación

// Obtener total de artículos
$totalPedidos = count($gestor->obtenerPedidos());
$totalPaginas = ceil($totalPedidos / $pedidosPorPagina);

// Si se realiza una búsqueda, asigna los pedidos encontrados
if (isset($_GET['buscar'])) {
    $pedidoEncontrado = $gestor->buscarPedido($_GET['buscar']);
    $pedidos = $pedidoEncontrado;  // Asignar los resultados de la búsqueda a la variable $pedidos
} else {
    $pedidos = $gestor->getPedidosPag($inicio, $pedidosPorPagina);  // Asigna los resultados de la paginación en vez de listar todos los pedidos
}

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

    <div class="container my-5">
        <h1 class="text-center mt-3 mb-4">Gestión de Pedidos</h1>
        <?php mostrarMensaje() ?>
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por código">
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
                        <th class="text-center">Editar</th>
                        <th class="text-center">Cancelar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pedido->getIdPedido()); ?></td>
                            <td><?php echo htmlspecialchars($pedido->getFecha()); ?></td>
                            <td><?php echo htmlspecialchars(number_format($pedido->getTotal(), 2)); ?>€</td>
                            <td><?php echo htmlspecialchars($pedido->getEstado()); ?></td>
                            <td><?php echo htmlspecialchars($pedido->getCod_Usuario()); ?></td>
                            <td class="text-center">
                                <a href="editar_pedido.php?idPedido=<?php echo htmlspecialchars($pedido->getIdPedido()); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="cancelarPedido.php?idPedido=<?php echo htmlspecialchars($pedido->getIdPedido()); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if(!isset($_GET['buscar'])){ ?>
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($pagina > 1): ?>
                        <li class="page-item">
                            <a class="page-link border border-warning text-dark" href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item">
                            <a class="page-link border border-warning text-dark <?= $pagina == $i ? 'active bg-warning text-dark' : '' ?>"
                               href="?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($pagina < $totalPaginas): ?>
                        <li class="page-item">
                            <a class="page-link border border-warning text-dark" href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php  }?>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

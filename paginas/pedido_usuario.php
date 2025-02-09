<?php
session_start();

require_once '../servidor/config.php';
require_once '../gestores/GestorPedidos.php';
include_once '../gestores/Pedido.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridadUsuario.php';

$db = conectar();

$gestor = new GestorPedidos($db);

$cod_usuario = $_SESSION['dni'];

$resultado = $gestor->obtenerPedidosUsuario($cod_usuario);

// Paginación
$pedidosPorPagina = 5;

// Obtener número de página actual 
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina < 1)
    $pagina = 1;

// Índice de inicio, primer artículo que se mostrará en la página 
$inicio = ($pagina - 1) * $pedidosPorPagina;

// Obtener pedidos paginados
$pedidos = $gestor->getPedidosPag($inicio, $pedidosPorPagina);

// Obtener total de artículos
$totalPedidos = count($gestor->obtenerPedidosUsuario($cod_usuario));
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

    <div class="container-fluid mt-4 flex-grow-1">
        <div class="row">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>
            <div class="col-md-8">
                <div class="content text-center">
                    <h2>Mis Pedidos</h2>
                    <?php mostrarMensaje() ?>
                    <div class="d-flex ms-auto justify-content-center p-3">
                        <form action="" method="GET" class="d-flex">
                            <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por código">
                            <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
                        </form>
                    </div>
                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>Numero</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Ver</th>
                                <th>Cancelar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $item) { ?>
                                <tr>
                                    <td><?= $item->getidPedido() ?></td>
                                    <td><?= $item->getFecha() ?></td>
                                    <td><?= $item->getTotal() ?>€</td>
                                    <td><?= $item->getEstado() ?></td>
                                    <td>
                                        <a
                                            href="ver_pedido.php?idPedido=<?php echo htmlspecialchars($item->getidPedido()); ?>">
                                            <i class="fa fa-eye"></i>


                                    </td>
                                    <td>
                                        <a
                                            href="cancelarPedido.php?idPedido=<?php echo htmlspecialchars($item->getidPedido()); ?>">
                                            <i class="fas fa-trash-alt"></i>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php if ($pagina > 1): ?>
                                <li class="page-item">
                                    <a class="page-link border border-warning text-dark"
                                        href="?pagina=<?= $pagina - 1 ?>">Anterior</a>
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
                                    <a class="page-link border border-warning text-dark"
                                        href="?pagina=<?= $pagina + 1 ?>">Siguiente</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <?php include '../plantillas/menuUsuario.php' ?>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
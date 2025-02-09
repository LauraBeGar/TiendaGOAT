<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/Usuario.php';
include_once '../gestores/GestorUsuarios.php';
include_once '../gestores/Producto.php';
include_once '../gestores/GestorProductos.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridadUsuario.php';

$db = conectar();
$gestor = new GestorProductos($db);
$productos = $gestor->obtenerProductosActivos();

// Número de artículos por página
$productosPorPagina = 3;

// Obtener número de página actual desde URL
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina < 1)
    $pagina = 1; // Evitar valores negativos

// Calcular el índice de inicio para la consulta
$inicio = ($pagina - 1) * $productosPorPagina;

$orden = $_GET["orden"] ?? "";
// Obtener artículos paginados
$productos = $gestor->getProductosPagActivos($inicio, $productosPorPagina, $orden);

// Obtener total de artículos
$totalProductos = count($gestor->obtenerProductos());
$totalPaginas = ceil($totalProductos / $productosPorPagina);
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

<body>

    <?php include '../plantillas/header.php' ?>

    <div class="container-fluid mt-4">
        <div class="row ">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>

            <div class="col-md-8">
                <div class="row g-4">
                <?php mostrarMensaje() ?>
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="card" style="width: 17rem;">
                                <?php if (!empty($producto->getImagen())): ?>
                                    <img src="/img/<?= htmlspecialchars($producto->getImagen()) ?>" class="card-img-top"
                                        alt="<?= htmlspecialchars($producto->getNombre()) ?>"
                                        style="width: 50%; height: 150px; object-fit: cover; display: block; margin: auto;">
                                <?php else: ?>
                                    <div class="p-3 text-center">No hay imagen disponible</div>
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($producto->getNombre()) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($producto->getDescripcion()) ?> </p>
                                    <p class="card-text fw-bold"><?= htmlspecialchars($producto->getPrecio()) ?> €</p>
                                    <a href="detalle_producto.php?codigo=<?= $producto->getCodigo()?>" class="btn btn-outline-warning text-dark mb-4">Ver Detalles</a>
                                    <a href="../servidor/c_carrito.php?codigo=<?= $producto->getCodigo() ?>&nombre=<?= $producto->getNombre() ?>&imagen=<?= $producto->getCodigo() ?>&precio=<?= $producto->getPrecio() ?>&categoria=<?= $producto->getCodigo() ?>"
                                        class="btn btn-outline-warning text-dark">Añadir al carrito</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php include '../plantillas/menuUsuario.php' ?>

            <!-- Paginación -->
            <nav>
                <ul class="pagination justify-content-center mt-4">
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
            <?php include '../plantillas/footer.php' ?>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
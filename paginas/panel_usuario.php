<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require_once '../servidor/config.php';
require_once '../gestores/Usuario.php';
require_once '../gestores/GestorUsuarios.php';
require_once '../gestores/Producto.php';
require_once '../gestores/GestorProductos.php';

$db = conectar();
$gestor = new GestorProductos($db);
$productos = $gestor->obtenerProductos();

// Número de artículos por página
$productosPorPagina = 3;

// Obtener número de página actual desde URL
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1; // Evitar valores negativos

// Calcular el índice de inicio para la consulta
$inicio = ($pagina - 1) * $productosPorPagina;

// Obtener artículos paginados
$productos = $gestor->getProductosPag($inicio, $productosPorPagina);

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
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <!-- Header -->
    <?php include '../plantillas/header.php' ?>

    <div class="container-fluid mt-4">
        <div class="row ">
        <div class="col-md-2">
            <?php include '../plantillas/menu.php'; ?>
        </div>
            
            <!-- Productos -->
            <div class="col-md-8"> <!-- Ajusta el tamaño de la columna de productos -->
                <div class="row g-4">
                    <?php foreach ($productos as $producto): ?>
                        <div class="col-md-4 d-flex justify-content-center">
                            <div class="card" style="width: 17rem;">
                                <?php if (!empty($producto->getImagen())): ?>
                                    <img src="/img/<?= htmlspecialchars($producto->getImagen()) ?>" class="card-img-top" alt="<?= htmlspecialchars($producto->getNombre()) ?>" style="width: 100%; height: 250px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="p-3 text-center">No hay imagen disponible</div>
                                <?php endif; ?>
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($producto->getNombre()) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($producto->getDescripcion()) ?> </p>
                                    <p class="card-text fw-bold"><?= htmlspecialchars($producto->getPrecio()) ?> €</p>
                                    <a href="../servidor/c_carrito.php?codigo=<?= $producto->getCodigo()?>&nombre=<?= $producto->getNombre() ?>&imagen=<?= $producto->getCodigo()?>&precio=<?= $producto->getPrecio() ?>&categoria=<?= $producto->getCodigo() ?>" class="btn btn-outline-warning text-dark">Añadir al carrito</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Aside -->
            <div class="col-md-2 bg-light p-3 text-center "> <!-- Ajusta el tamaño de la columna del aside -->
                <h4>Hola, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?>!</h4>
                <div class="links">
                    <div><a href="cuenta_usuario.php" class="text-decoration-none text-color-custom">Mi Cuenta</a></div>
                    <div><a href="pedido_usuario.php" class="text-decoration-none text-color-custom">Mis pedidos</a></div>
                    <div><a href="cambiar_clave.php" class="text-decoration-none text-color-custom">Cambiar contraseña</a></div>
                    <div class="logout mt-3 text-bold">
                        <a href="/servidor/logout.php" class="text-decoration-none text-danger font-weight-bold">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <nav>
        <ul class="pagination justify-content-center mt-4">
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

    <!-- Footer -->
    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

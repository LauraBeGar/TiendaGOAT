<?php
session_start();
include '../gestores/GestorProductos.php';
include '../servidor/config.php';

$db = conectar();

$gestor = new GestorProductos($db);

$productos = $gestor->obtenerProductos();

// paginacion
$productosPorPagina = 3;

// Obtener número de página actual 
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina < 1)
    $pagina = 1; 

//indice de inicio, primer articulo que se mostrara en la pagina 
$inicio = ($pagina - 1) * $productosPorPagina;

// Obtener artículos paginados
$productos = $gestor->getProductosPag($inicio, $productosPorPagina, "");

// Obtener total de artículos
$totalProductos = count($gestor->obtenerProductos());
$totalPaginas = ceil($totalProductos / $productosPorPagina);

if (isset($_GET['ordenar']) && $_GET['ordenar'] == 'nombre') {
    $orden = isset($_GET['orden']) && strtolower($_GET['orden']) == 'desc' ? 'DESC' : 'ASC';
    $productos = $gestor->ordenarProductoPorNombre($orden);
} elseif (isset($_GET['buscar'])) {
    $productos = $gestor->buscarProducto($_GET['buscar']);
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
        <h1 class="text-center mb-4">Gestión de Productos</h1>

        <!-- Barra de opciones -->
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o ID">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
            </form>
            <form action="alta_producto.php" method="GET">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Dar de alta</button>
            </form>
            <form action="gestion_productos.php" method="GET" class="ms-2">
            <input type="hidden" name="ordenar" value="nombre">
            <input type="hidden" name="orden" value="asc">
            <button type="submit" class="btn btn-warning btn-custom">Ordenar A-Z</button>
        </form>

        <form action="gestion_productos.php" method="GET" class="ms-2">
            <input type="hidden" name="ordenar" value="nombre">
            <input type="hidden" name="orden" value="desc">
            <button type="submit" class="btn btn-warning btn-custom">Ordenar Z-A</button>
        </form>
    </div>

        <!-- Tabla de clientes -->
        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                        <th>Categoria</th>
                        <th>Precio</th>
                        <th>Activo</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Dar de Baja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto->getCodigo()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getDescripcion()); ?></td>
                            <td>
                                <img src="/img/<?php echo htmlspecialchars($producto->getImagen()); ?>" class="img-thumbnail" width="100">
                            </td>
                            <td><?php echo htmlspecialchars($producto->getCategoria()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getPrecio()); ?></td>
                            <td><?php echo htmlspecialchars($producto->getActivo() == 1 ? 'Activo' : 'Inactivo'); ?></td>
                            <td class="text-center">
                                <a href="editar_producto.php?codigo=<?php echo htmlspecialchars($producto->getCodigo()); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a
                                    href="baja_producto.php?codigo=<?php echo htmlspecialchars($producto->getCodigo()); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
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
        </div>
    </div>
    <?php include '../plantillas/footer.php' ?>
</body>

</html>
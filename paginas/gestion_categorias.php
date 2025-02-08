<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorCategoria.php';
include_once '../gestores/Categoria.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridad.php';

$db = conectar();

$gestor = new GestorCategorias($db);

$categorias = $gestor->obtenerCategorias();

// paginacion
$categoriasPorPagina = 5;

// Obtener número de página actual 
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina < 1)
    $pagina = 1; 

//indice de inicio, primer articulo que se mostrara en la pagina 
$inicio = ($pagina - 1) * $categoriasPorPagina;

//artículos paginados
$categorias = $gestor->getCategoriasPag($inicio, $categoriasPorPagina);

// Obtener total de artículos
$totalCategorias = count($gestor->obtenerCategorias());
$totalPaginas = ceil($totalCategorias / $categoriasPorPagina);


if(isset($_GET['buscar'])) {
    $categorias = $gestor->buscarCategoria($_GET['buscar']);
    };


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
        <h1 class="text-center mt-3 mb-4">Gestión de Categorias</h1>
        <?php mostrarMensaje() ?>
        <!-- Barra de opciones -->
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o codigo">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
            </form>
            <form action="alta_categoria.php" method="GET">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Crear Categoria</button>
            </form>
        </div>
        <div class="table-container">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Activo</th>
                        <th>Categoria Padre</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Dar de baja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($categoria->getCodigo()); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getNombre()); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getActivo() == 1 ? 'Activo' : 'Inactivo'); ?></td>
                            <td><?php echo htmlspecialchars($categoria->getcodCategoriaPadre()); ?></td>
                            
                            <td class="text-center">
                                <a href="editar_categoria.php?codigo=<?php echo htmlspecialchars($categoria->getCodigo()); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a
                                    href="baja_categoria.php?codigo=<?php echo htmlspecialchars($categoria->getCodigo()); ?>">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
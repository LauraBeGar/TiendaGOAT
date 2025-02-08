<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorProductos.php';
include_once '../gestores/Producto.php';
include_once '../gestores/GestorCategoria.php';
require_once '../servidor/seguridad.php';

$db = conectar();

$gestor = new GestorCategorias($db);

$categorias = $gestor->getOptionCategoria();

if (isset($_GET['codigo'])) {
    $codigo = htmlspecialchars(trim($_GET['codigo']));
    $gestor = new GestorProductos($db);
    $producto = $gestor->getProductoPorCodigo($codigo);

    if (!$producto) {
        header('Location: gestion_articulos.php?error=articulo no encontrado');
        exit();
    }
} else {
    header('Location: gestion_articulos.php?error=sin codigo');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Artículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container-fluid mt-4 flex-grow-1">
        <h1 class="text-center mb-4">Gestión de Productos</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content p-3">
                    <h2 class="text-center">Editar Producto</h2>
                    <form action="/servidor/editarProducto.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <input type="hidden" id="activo" name="activo" value="1">
                            <div class="col-md-6">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" id="codigo" name="codigo" class="form-control"
                                    value="<?= htmlspecialchars($producto['codigo']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control"
                                    value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                            </div>

                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                                    required><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select id="categoria" name="categoria" class="form-control" required>
                                    <?php foreach ($categorias as $categoria) { ?>
                                        <option value="<?= $categoria["codigo"] ?>"><?= $categoria["nombre"] ?></option>
                                    <?php } ?>
                                </select>

                            </div>
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" id="precio" name="precio" class="form-control"
                                    value="<?= htmlspecialchars($producto['precio']) ?>" step="0.01" required>
                            </div>

                            <div class="col-md-6">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" id="imagen" name="imagen" class="form-control"
                                    accept="image/jpeg, image/jpg, image/png, image/gif">
                                <?php if ($producto['imagen']): ?>
                                    <div class="mt-2">
                                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen actual"
                                            width="100">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label for="activo" class="form-label">Activo</label>
                                <select id="activo" name="activo" class="form-control" required>
                                    <option value="1" <?= $producto['activo'] == 1 ? 'selected' : '' ?>>1</option>
                                    <option value="0" <?= $producto['activo'] == 0 ? 'selected' : '' ?>>0</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-warning me-5">Guardar</button>
                            <a href="gestion_productos.php" class="btn btn-outline-warning text-dark">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../plantillas/footer.php' ?>
</body>

</html>
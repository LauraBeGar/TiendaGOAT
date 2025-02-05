<?php
session_start();

include_once '../servidor/seguridad.php';
include_once '../servidor/config.php';
include_once '../gestores/GestorCategoria.php';

$db = conectar();

$gestor = new GestorCategorias($db);

$categorias = $gestor->getOptionCategoria();


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta de Artículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <?php include '../plantillas/menuAdmin.php' ?>

    <div class="container my-5">
        <h1 class="text-center mb-4">Gestión de Productos</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content p-3">
                    <h2 class="text-center">Alta de Productos</h2>
                    <form action="../servidor/altaProducto.php" method="post" enctype="multipart/form-data">
                        <div class="row g-3">
                            <input type="hidden" id="activo" name="activo" value="1">
                            <div class="col-md-6">

                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" id="codigo" name="codigo" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>

                            <div class="col-md-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                                    required></textarea>
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
                                <input type="number" id="precio" name="precio" class="form-control" step="0.01"
                                    required>
                            </div>

                            <div class="col-md-12">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" id="imagen" name="imagen" class="form-control"
                                    accept="image/jpeg, image/jpg, image/png, image/gif" required>
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
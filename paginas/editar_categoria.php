<?php
session_start();
require_once '../servidor/config.php';
include '../gestores/GestorCategoria.php';
include_once '../gestores/Categoria.php';

$db = conectar();
$gestor = new GestorCategorias($db);
$categoria = null;
$padres = $gestor->getCategoriaPadres();

// Verificar si se reciben los datos esperados en $_GET
if (isset($_GET['codigo'])) {
    $codigo = htmlspecialchars(trim($_GET['codigo']));
    $categoria = $gestor->getCategoriaPorCodigo($codigo);

    if ($categoria instanceof Categoria) {
        $codigoActual = htmlspecialchars($categoria->getCodigo());
        $nombreActual = htmlspecialchars($categoria->getNombre());
        $activoActual = htmlspecialchars($categoria->getActivo());
        $categoriaPadreActual = htmlspecialchars($categoria->getcodCategoriaPadre());
    } else {
        $codigoActual = "";
        $nombreActual = "";
        $activoActual = "";
        $categoriaPadreActual = "0";
    }
}

// Si se envía el formulario, actualizar la categoría
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo'], $_POST['nombre'], $_POST['activo'], $_POST['codCategoriaPadre'])) {
        $codigo = htmlspecialchars(trim($_POST['codigo']));
        $nombre = htmlspecialchars(trim($_POST['nombre']));
        $activo = htmlspecialchars(trim($_POST['activo']));
        $codCategoriaPadre = htmlspecialchars(trim($_POST['codCategoriaPadre']));

        $categoriaEditada = new Categoria($codigo, $nombre, $activo, $codCategoriaPadre);

        if ($gestor->editarCategoria($categoriaEditada)) {
            header("Location: gestion_categorias.php?mensaje=La categoría se ha modificado con éxito");
            exit();
        } else {
            header("Location: gestion_categorias.php?mensaje=Error al modificar la categoría");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda GOAT - Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="style1.css">
</head>

<body>
    <?php include '../plantillas/header.php' ?>

    <?php if (isset($_SESSION['rol'])): ?>
        <?php if ($_SESSION['rol'] == 1): ?>
            <?php include '../plantillas/menuAdmin.php'; ?>
        <?php elseif ($_SESSION['rol'] == 2): ?>
            <?php include '../plantillas/menuEditor.php'; ?>
        <?php endif; ?>
    <?php endif; ?>

    <div class="container-fluid">
        <h1 class="text-center mt-3 mb-4">Editar Categoría</h1>

        <!-- Barra de opciones -->
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="" method="GET" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o ID">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
            </form>
            <form action="crear_categoria.php" method="GET">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Crear Categoría</button>
            </form>
        </div>

        <!-- Formulario para editar una categoría -->
        <div class="row">
            <form action="" method="post" class="col-12 col-md-6 mx-auto p-4">
                <h5 class="text-center mb-4">Editar Categoría</h5>

                <div class="mb-3">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" value="<?= $codigoActual ?>"
                        readonly required>
                </div>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $nombreActual ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label for="activo" class="form-label">Estado:</label>
                    <select class="form-select" id="activo" name="activo">
                        <option value="1" <?= ($activoActual == 1) ? 'selected' : ''; ?>>Activo</option>
                        <option value="0" <?= ($activoActual == 0) ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="codCategoriaPadre" class="form-label">Categoría Padre:</label>
                    <select class="form-select" id="codCategoriaPadre" name="codCategoriaPadre">
                        <option value="0" <?= ($categoriaPadreActual == "0") ? 'selected' : ''; ?>>Padre</option>
                        <?php foreach ($padres as $padre) { ?>
                            <option value="<?= $padre["codigo"] ?>" <?= ($categoriaPadreActual == $padre["codigo"]) ? 'selected' : ''; ?>>
                                <?= $padre["nombre"] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn bg-secondary-custom me-5">Guardar Cambios</button>
                    <a href="gestion_categorias.php" class="btn btn-outline-warning text-dark">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
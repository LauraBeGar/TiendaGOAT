<?php
session_start();
require_once '../servidor/config.php';
include '../gestores/GestorCategoria.php';

$db = conectar();

$gestor = new GestorCategorias($db);

$padres = $gestor->getCategoriaPadres();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['codigo'], $_POST['categoria'], $_POST['activo'], $_POST['codCategoriaPadre'])) {
        $codigo = htmlspecialchars(trim($_POST['codigo']));
        $nombreCategoria = htmlspecialchars(trim($_POST['categoria']));
        $activo = htmlspecialchars(trim($_POST['activo']));
        $codCategoriaPadre = htmlspecialchars(trim($_POST['codCategoriaPadre']));



        if ($gestor->crearCategoria($codigo, $nombreCategoria, $activo, $codCategoriaPadre)) {
            header("Location: gestion_categorias.php?mensaje=la categoria se ha creado con éxito");
            exit();
        } else {
            header("Location: crear_categoria.php?mensaje=error al crear la categoria");
            exit();
        }

    }
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
    <?php if ($_SESSION['rol'] == 1) {
        include '../plantillas/menuAdmin.php';
    } elseif ($_SESSION['rol'] == 2) {
        include '../plantillas/menuEditor.php';

    }
    ?>
    <div class="container-fluid">
        <h1 class="text-center mt-3 mb-4">Gestión de Categorias</h1>

        <!-- Barra de opciones -->
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="" method="post" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o ID">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
            </form>
            <form action="crear_categoria.php" method="GET">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Crear Categoria</button>
            </form>

        </div>

        <!-- Formulario para crear una categoría -->
        <div class="row">
            <form action="" method="post" class="col-12 col-md-6 mx-auto p-4 ">
                <h5 class="text-center mb-4">Crear Categoría</h5>

                <div class="mb-3">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese el código"
                        required>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Nombre de la Categoría:</label>
                    <input type="text" class="form-control" id="categoria" name="categoria"
                        placeholder="Ingrese el nombre de la categoría" required>
                </div>
                <div class="mb-3">
                    <label for="activo" class="form-label">Estado:</label>
                    <select class="form-select" id="activo" name="activo">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="categoriaPadre" class="form-label">Codigo de la Categoría Padre:</label>
                    <select class="form-control" id="codCategoriaPadre" name="codCategoriaPadre">
                        <option value="0">Padre</option>
                        <?php foreach ($padres as $padre) { ?>
                            <option value="<?= $padre["codigo"] ?>"><?= $padre["nombre"] ?></option>
                        <?php } ?>
                    </select>

                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn bg-secondary-custom">Crear Categoría</button>
                </div>
            </form>
        </div>
    </div>


    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
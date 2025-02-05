<?php
session_start();
require_once '../servidor/config.php';
require_once '../gestores/GestorCategoria.php';
require_once '../gestores/Categoria.php';

require '../servidor/seguridad.php';

// Verificar que se envió un código válido
if (!isset($_GET['codigo'])) {
    header("Location: gestion_categorias.php?mensaje=No se proporcionó un código válido");
    exit();
}

$codigo = htmlspecialchars(trim($_GET['codigo']));

$db = conectar();

$gestor = new GestorCategorias($db);

$categoria = $gestor->getCategoriaPorCodigo($codigo);

if (!$categoria) {
    header("Location: gestion_categorias.php?mensaje=Categoría no encontrada");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($gestor->bajaCategoria($codigo)) {
        header("Location: gestion_categorias.php?mensaje=Categoría dada de baja con éxito");
    } else {
        header("Location: gestion_categorias.php?mensaje=Error al dar de baja la categoría");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Baja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <?php include '../plantillas/menuAdmin.php' ?>

    <div class="container mt-5">
        <h2 class="text-center">Confirmar Baja</h2>
        <p class="text-center">¿Estás seguro de que deseas dar de baja la categoría <strong><?php echo htmlspecialchars($categoria->getNombre()); ?></strong>?</p>

        <form method="POST" class="text-center">
            <button type="submit" class="btn btn-danger">Sí, dar de baja</button>
            <a href="gestion_categorias.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../plantillas/footer.php' ?>
</body>

</html>
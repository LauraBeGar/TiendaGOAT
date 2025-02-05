<?php
session_start();

require_once '../servidor/config.php';
require_once '../gestores/GestorUsuarios.php';
require_once '../gestores/Usuario.php';

require '../servidor/seguridad.php';

$dni = htmlspecialchars(trim($_GET['dni']));

$db = conectar();

$gestor = new GestorUsuarios($db);

$usuario = $gestor->obtener_datos_dni($dni);

if (!$usuario) {
    header("Location: gestion_usuarios.php?mensaje=Usuairio no encontrado");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($gestor->bajaUsuario($dni)) {
        header("Location: gestion_usuarios.php?mensaje=Usuario dado de baja con éxito");
    } else {
        header("Location: gestion_usuarios.php?mensaje=Error al dar de baja el usuario");
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
        <p class="text-center">¿Estás seguro de que deseas dar de baja el usuario <strong><?php echo htmlspecialchars($usuario['dni']); ?></strong>?</p>

        <form method="POST" class="text-center">
            <button type="submit" class="btn btn-danger">Sí, dar de baja</button>
            <a href="gestion_usuarios.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../plantillas/footer.php' ?>
</body>

</html>
<?php
session_start();
require_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridadUsuario.php';

$db = conectar();
$gestor = new GestorUsuarios($db);

$dni = $_SESSION['dni'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $gestor->bajaUsuario($dni);

    if ($resultado) {

        session_destroy();
        $mensaje = "Cuenta eliminada exitosamente.";
    } else {
        $mensaje = "Error al eliminar la cuenta.";
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
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php include '../plantillas/header.php' ?>
    <div class="container-fluid mt-4 flex-grow-1">
        <div class="row">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php' ?>
            </div>
            <div class="col-md-8">
                <div class="content text-center p-3">
                    <h2>Eliminar Cuenta</h2>
                    <?php mostrarMensaje() ?>
                    <?php if (isset($mensaje)): ?>
                        <div class="alert alert-info"><?php echo $mensaje; ?></div>
                    <?php endif; ?>
                    <div class="mt-5">
                        <form action="" method="post">
                            <h6>¿Estás seguro de que quieres eliminar tu cuenta?</h6>
                            <!-- Botones -->
                            <div class="mt-5">
                                <button type="submit" class="btn bg-secondary-custom me-2">Eliminar</button>
                                <a href="cuenta_usuario.php"><button type="button"
                                        class="btn bg-secondary-custom">Cancelar</button>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php include '../plantillas/menuUsuario.php' ?>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
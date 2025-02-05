<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
require_once '../servidor/config.php';
require_once '../gestores/GestorUsuarios.php';

$db = conectar();
$gestor = new GestorUsuarios($db);

$email=$_SESSION['email'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $gestor->eliminar_usuario($email);

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
    <link rel="stylesheet" href="./estilos/style1.css">
</head>

<body>
<?php include '../plantillas/header.php' ?>
<?php include '../plantillas/menuAdmin.php' ?>
    <!-- Main -->
    <div class="col-md-7">
        <div class="content text-center p-3">
            <h2>Eliminar Cuenta</h2>
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-info"><?php echo $mensaje; ?></div>
            <?php endif; ?>
            <div class="mt-5">
                <form action="" method="post">
                <h6>¿Estás seguro de que quieres eliminar tu cuenta?</h6>
                <!-- Botones de enviar y cancelar -->
                <div class="mt-5">
                    <button type="submit" class="btn bg-secondary-custom me-2">Eliminar</button>
                    <a href="cuenta_usuario.php"><button type="button" class="btn bg-secondary-custom">Cancelar</button>
                    </a>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Aside -->
    <div class="col-md-3 bg-light p-3 text-center justify-content-end">
        <h4>Hola, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?>!
        </h4>
        <div class="links">
            <div>
                <a href="cuenta_usuario.php" class="text-decoration-none text-color-custom">Mi Cuenta</a>
            </div>
            <div>
                <a href="pedidos.php" class="text-decoration-none text-color-custom">Mis pedidos</a>
            </div>
            <div>
                <a href="cambiar_clave.php" class="text-decoration-none text-color-custom">Cambiar
                    contraseña</a>
            </div>
            <div class="logout mt-3 text-bold">
                <a href="logout.php" class="text-decoration-none text-color-custom font-weight-bold ">
                    Cerrar sesión</a>
            </div>
        </div>
    </div>
    </div>
    </div>
    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
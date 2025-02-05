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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_clave = htmlspecialchars(trim($_POST['nueva_clave']));

    $email = $_SESSION['email'];
    $resultado = $gestor->cambiar_clave($email, $nueva_clave);

    if ($resultado) {
        $mensaje = "Contraseña cambiada exitosamente.";
        
    } else {
        $mensaje = "Error al cambiar la contraseña.";
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

<body class="d-flex flex-column min-vh-100"> <!-- Flexbox con altura mínima del 100% -->

<?php include '../plantillas/header.php' ?>

    <div class="container-fluid mt-4 flex-grow-1"> <!-- Flex-grow para que el contenido se expanda -->
        <div class="row">
            <div class="col-md-2">
                <?php include 'menu.php'; ?>
            </div>
            <div class="col-md-7">
                <div class="content text-center p-3">
                    <h2>Cambiar contraseña</h2>
                    <?php if (isset($mensaje)): ?>
                    <div class="alert alert-info"><?php echo $mensaje; ?></div>
                <?php endif; ?>
                    <form action="" method="post">
                        <!-- Campo con label e input en línea -->
                        <div class="form-group d-flex justify-content-center mt-5">
                            <label for="nueva_clave" class="me-5">Introduce tu nueva contraseña:</label>
                            <input type="password" id="nueva_clave" name="nueva_clave" class="form-control w-50"
                                placeholder="Escribe aquí">
                        </div>

                        <!-- Botones de enviar y cancelar -->
                        <div class="mt-5">
                            <button type="submit" class="btn bg-secondary-custom me-2">Enviar</button>
                            <a href="cuenta_usuario.php"><button  type="button" class="btn bg-secondary-custom">Cancelar</button></a>
                        </div>
                    </form>
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
                        <a href="pedido_usuario.php" class="text-decoration-none text-color-custom">Mis pedidos</a>
                    </div>
                    <div>
                        <a href="cambiar_clave.php" class="text-decoration-none text-color-custom">Cambiar
                            contraseña</a>
                    </div>
                    <div class="logout mt-3 text-bold">
                        <a href="logout.php"
                            class="text-decoration-none text-danger font-weight-bold "> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';
include_once '../gestores/Usuario.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridadUsuario.php';



$db = conectar();
$gestor = new GestorUsuarios($db);
$error = $_GET['error'] ?? null;
$email = $_SESSION['email'];
$usuario = $gestor->obtener_datos_usuario($email);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
    <div class="container-fluid mt-4 flex-grow-1">
        <div class="row">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>
            <div class="col-md-8 justify-content-center">
                <div class="content p-3">
                    <h2 class="text-center mb-3">Completa los datos para seguir con la compra</h2>
                    <?php mostrarMensaje() ?>
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>
                    <form action="../servidor/checkout.php" method="post">
                        <div class="row">
                            <!-- Primera fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" id="dni" name="dni" class="form-control"
                                    value="<?php echo $usuario['dni']; ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    value="<?php echo $usuario['email']; ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Segunda fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control"
                                    value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control"
                                    value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tercera fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección:</label>
                                <input type="text" id="direccion" name="direccion" class="form-control"
                                    value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="localidad" class="form-label">Localidad:</label>
                                <input type="text" id="localidad" name="localidad" class="form-control"
                                    value="<?php echo htmlspecialchars($usuario['localidad']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Cuarta fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="provincia" class="form-label">Provincia:</label>
                                <input type="text" id="provincia" name="provincia" class="form-control"
                                    value="<?php echo htmlspecialchars($usuario['provincia']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control"
                                    value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                            </div>
                        </div>
                </div>
                <div class="text-center mb-5">
                <button type="submit" class="btn btn-secondary-custom link-hover-custom ">Continuar</button>
                </div>
                </form>
            </div>
            <?php include '../plantillas/menuUsuario.php' ?>
        </div>
    </div>
    

    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
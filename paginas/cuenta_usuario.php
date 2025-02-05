<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
require_once 'config.php';
require_once 'GestorUsuarios.php';

$db = conectar();
$gestor = new GestorUsuarios($db);

$email = $_SESSION['email'];
$usuario = $gestor->obtener_datos_usuario($email);
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
                <?php include '../plantillas/menu.php'; ?>
            </div>
            <div class="col-md-7">
                <div class="content">
                    <h2>Mi Cuenta</h2>
                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Dirección</th>
                                <th>Localidad</th>
                                <th>Provincia</th>
                                <th>Teléfono</th>
                                <th>Email</th>
                                <th>Editar</th>
                                <th>Borrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo isset($usuario['dni']) ? htmlspecialchars($usuario['dni']) : '' ?></td>
                                <td><?php echo isset($usuario['nombre']) ? htmlspecialchars($usuario['nombre']) : '' ?></td>
                                <td><?php echo isset($usuario['apellidos']) ? htmlspecialchars($usuario['apellidos']) : '' ?></td>
                                <td><?php echo isset($usuario['direccion']) ? htmlspecialchars($usuario['direccion']) : '' ?></td>
                                <td><?php echo isset($usuario['localidad']) ? htmlspecialchars($usuario['localidad']) : '' ?></td>
                                <td><?php echo isset($usuario['provincia']) ? htmlspecialchars($usuario['provincia']) : '' ?></td>
                                <td><?php echo isset($usuario['telefono']) ? htmlspecialchars($usuario['telefono']) : '' ?></td>
                                <td><?php echo isset($usuario['email']) ? htmlspecialchars($usuario['email']) : '' ?></td>
                                <td>
                                    <a href="editar.php" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="eliminar_usuario.php" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Aside -->
            <div class="col-md-3 bg-light p-3 text-center justify-content-end">
                <h4>Hola, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?>!</h4>
                <div class="links">
                    <div>
                        <a href="cuenta_usuario.php" class="text-decoration-none text-color-custom">Mi Cuenta</a>
                    </div>
                    <div>
                        <a href="pedido_usuario.php" class="text-decoration-none text-color-custom">Mis pedidos</a>
                    </div>
                    <div>
                        <a href="cambiar_clave.php" class="text-decoration-none text-color-custom">Cambiar contraseña</a>
                    </div>
                    <div class="logout mt-3 text-bold">
                        <a href="logout.php" class="text-decoration-none text-danger font-weight-bold">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../plantillas/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
require_once 'GestorUsuarios.php';
require_once 'Usuario.php';  

$db = conectar();
$gestor = new GestorUsuarios($db);

$email = $_SESSION['email'];
$usuario = $gestor->obtener_datos_usuario($email);

$usuarioObj = new Usuario(
    $usuario['dni'],
    $usuario['clave'],
    $usuario['nombre'],
    $usuario['apellidos'],
    $usuario['direccion'],
    $usuario['localidad'],
    $usuario['provincia'],
    $usuario['telefono'],
    $usuario['email'],
    $usuario['rol'],
    $usuario['activo']
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $direccion = htmlspecialchars(trim($_POST['direccion']));
    $localidad = htmlspecialchars(trim($_POST['localidad']));
    $provincia = htmlspecialchars(trim($_POST['provincia']));
    $telefono = htmlspecialchars(trim($_POST['telefono']));

    // Actualizamos los datos en el objeto Usuario
    $usuarioObj->setNombre($nombre);
    $usuarioObj->setApellidos($apellidos);
    $usuarioObj->setDireccion($direccion);
    $usuarioObj->setLocalidad($localidad);
    $usuarioObj->setProvincia($provincia);
    $usuarioObj->setTelefono($telefono);

    // Ahora pasamos el objeto Usuario al GestorUsuarios para actualizar
    $resultado = $gestor->actualizar_datos_usuario($usuarioObj);

    if ($resultado) {
        header('Location: cuenta_usuario.php?mensaje=Información actualizada correctamente');
        exit();
    } else {
        header('Location: cuenta_usuario.php?mensaje=Error al actualizar la informacion');
        exit();
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
    <?php include 'header.php' ?>
   <?php  include 'menu.php' ?>
            <!-- Main Content Area -->
            <div class="col-md-7">
                <div class="content text-center p-3">
                    <h2>Editar Información</h2>
                    <?php if (isset($mensaje)): ?>
                    <div class="alert alert-info"><?php echo $mensaje; ?></div>
                <?php endif; ?>
                    <form action="" method="post">
                     <!-- Campo con label e input en línea -->
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="dni" class="me-5">DNI:</label>
                        <input type="text" id="dni" name="dni" class="form-control w-50 bg-light" value="<?php echo htmlspecialchars($usuario['dni']); ?>" readonly>
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="email" class="me-5">Email:</label>
                        <input type="text" id="email" name="email" class="form-control w-50 bg-light" value="<?php echo htmlspecialchars($usuario['email']); ?>" readonly>
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="nombre" class="me-5">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control w-50" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" placeholder="">
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="apellidos" class="me-5">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" class="form-control w-50" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" placeholder="">
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="direccion" class="me-5">Dirección:</label>
                        <input type="text" id="direccion" name="direccion" class="form-control w-50" value="<?php echo htmlspecialchars($usuario['direccion']); ?>" placeholder="">
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="localidad" class="me-5">Localidad:</label>
                        <input type="text" id="localidad" name="localidad" class="form-control w-50" value="<?php echo htmlspecialchars($usuario['localidad']); ?>" placeholder="">
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="provincia" class="me-5">Provincia:</label>
                        <input type="text" id="provincia" name="provincia" class="form-control w-50" value="<?php echo htmlspecialchars($usuario['provincia']); ?>" placeholder="">
                    </div>
                    <div class="form-group d-flex justify-content-center mt-5">
                        <label for="telefono" class="me-5">Teléfono:</label>
                        <input type="text" id="telefono" name="telefono" class="form-control w-50" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" placeholder="">
                    </div>

                        <!-- Botones de enviar y cancelar -->
                        <div class="mt-5">
                            <button type="submit" class="btn bg-secondary-custom me-2">Enviar</button>
                            <a href="cuenta_usuario.php"><button type="button" class="btn bg-secondary-custom">Cancelar</button>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Aside-->
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
                        <a href="../controladores/logout.php"
                            class="text-decoration-none text-color-custom font-weight-bold "> Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
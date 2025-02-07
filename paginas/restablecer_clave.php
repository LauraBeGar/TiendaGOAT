<?php
session_start();

include "../servidor/config.php";
include "../gestores/GestorUsuarios.php";

if (isset($_SESSION["usuario"])) {
    header("Location: ../index.php");
    exit;
}

// Variable para manejar el estado del formulario
$encontrado = false;

// Verificación de datos si el formulario fue enviado
if (isset($_POST["email"]) || isset($_POST["dni"])) {
    $dni = htmlspecialchars(trim($_POST["dni"]));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $db = conectar();

    $gestor = new GestorUsuarios($db);

    $usuario = $gestor->obtener_datos_dni($dni);

    if ($usuario && $usuario['email'] === $email) {
        $_SESSION['dni_recuperar'] = $dni;
        $_SESSION['email_recuperar'] = $email;
        // Si el dni y el email coinciden, mostramos el formulario para cambiar la contraseña
        $encontrado = true;
    } else {

        header('Location: restablecer_clave.php?error=No hay usuarios registrado con esos datos');
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña</title>
    <!-- Incluir Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./estilos/style1.css">
</head>
<?php include '../plantillas/header.php' ?>

<body class="bg-light">
    <?php if (!$encontrado) { ?>

        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row w-100">
                <div class="col-md-6 col-lg-4 mx-auto bg-white p-4 rounded shadow-sm">
                    <h3 class="text-center mb-4">Restablecer Contraseña</h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" pattern="[0-9]{8}[A-Za-z]" title="Debe contener 8 dígitos y una letra" maxlength="9" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" maxlength="30" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Verificar</button>
                    </form>
                    <br><br>
                    <a href="../index.php">Volver</a>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row w-100">
                <div class="col-md-6 col-lg-4 mx-auto bg-white p-4 rounded shadow-sm">
                    <h3 class="text-center mb-4">Cambiar Contraseña</h3>
                    <form action="/servidor/restablecerClave.php" method="post">
                        <div class="mb-3">
                            <label for="clave" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" name="clave" id="clave" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php include '../plantillas/footer.php' ?>
    <!-- Incluir Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
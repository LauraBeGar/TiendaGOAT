<?php
session_start();
include_once '../servidor/mensajes.php';
// Redirigir al panel según el rol del usuario si está logueado
if (isset($_SESSION["email"])) {
    if ($_SESSION['rol'] == 0) {
        header('Location: panel_usuario.php');
    } elseif ($_SESSION['rol'] == 1) {
        header('Location: panel_administrador.php');
    } elseif ($_SESSION['rol'] == 2) {
        header('Location: panel_editor.php');
    }
    exit();
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <main class="container-fluid d-flex justify-content-center align-items-center p-4 bg-light">
        <div class="row w-100 justify-content-center">
            <div class="col-md-6 col-lg-4 login-card text-center bg-white p-5 shadow rounded">
                <h2 class="row mb-4 justify-content-center">Iniciar Sesión</h2>
                <?php mostrarMensaje() ?>
                <form name="login" action="/servidor/c_login.php" method="post">
                    <div class="row mb-3">
                        <label for="usuario" class="form-label visually-hidden">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </span>
                            <input type="email" id="email-login" name="email" class="form-control"
                                placeholder="Introduce tu email" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="clave" class="form-label visually-hidden">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-lock-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2" />
                                </svg>
                            </span>
                            <input type="password" id="clave-login" name="clave" class="form-control"
                                placeholder="Contraseña" required>
                        </div>
                    </div>
                    <button type="submit" class="btn bg-secondary-custom link-hover-custom">Acceder</button>
                </form>
                <a href="restablecer_clave.php" class="d-block mt-3 text-decoration-none text-color-custom">¿Has
                    olvidado tu contraseña?</a>
                <a href="#" class="d-block mt-3 text-decoration-none text-dark">¿No tienes cuenta?</a>
                <a href="registro.php" class="d-block mt-3 text-decoration-none text-color-custom">Registrate</a>
            </div>
        </div>
    </main>

    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();


require_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';
require_once '../servidor/seguridadUsuario.php';

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
    <title>Cambiar clave</title>
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
                <?php include '../plantillas/menu.php'; ?>
            </div>
            <div class="col-md-8">
                <div class="content text-center p-3">
                    <h2>Cambiar contraseña</h2>
                    <?php if (isset($mensaje)): ?>
                    <div class="alert alert-info"><?php echo $mensaje; ?></div>
                <?php endif; ?>
                    <form action="" method="post">
                        <div class="form-group d-flex justify-content-center mt-5">
                            <label for="nueva_clave" class="me-5">Introduce tu nueva contraseña:</label>
                            <input type="password" id="nueva_clave" name="nueva_clave" class="form-control w-50"
                                placeholder="Escribe aquí">
                        </div>

                        <!-- Botones-->
                        <div class="mt-5">
                            <button type="submit" class="btn bg-secondary-custom me-2">Enviar</button>
                            <a href="cuenta_usuario.php"><button  type="button" class="btn bg-secondary-custom">Cancelar</button></a>
                        </div>
                    </form>
                </div>
            </div>
      <?php include '../plantillas/menuUsuario.php' ?>
        </div>
    </div>
   
    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
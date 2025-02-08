<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';
include_once '../gestores/Usuario.php'; 
require_once '../servidor/seguridadAdmin.php';

$db = conectar();
$gestor = new GestorUsuarios($db);

if (isset($_GET['dni'])) {
    $dni = $_GET['dni'];  
    $usuario = $gestor->obtener_datos_dni($dni); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $usuario = new Usuario(
        $dni, 
        htmlspecialchars(trim($_POST['nombre'])),
        htmlspecialchars(trim($_POST['apellidos'])),
        htmlspecialchars(trim($_POST['direccion'])),
        htmlspecialchars(trim($_POST['localidad'])),
        htmlspecialchars(trim($_POST['provincia'])),
        htmlspecialchars(trim($_POST['telefono'])),
        htmlspecialchars(trim($_POST['email'])),
        $_POST['rol'],
        $_POST['estado']
    );

    
    $resultado = $gestor->actualizar_datos_usuario($usuario);

    if ($resultado) {
        header('Location: gestion_usuarios.php?mensaje=Información actualizada con éxito');
        exit();
    } else {
       header('Location:gestion_usuarios.php?mensaje=error al actualizar la informacion');
       exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../estilos/style1.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <?php include_once '../plantillas/header.php' ?>
    <?php
    include '../plantillas/menuAdmin.php';
    ?>
    <div class="container-fluid mt-4 flex-grow-1">
        <h1 class="text-center mb-4">Gestión de Usuarios</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content p-3">
                    <h2 class="text-center">Editar Información</h2>
                    <form action="" method="post">
                        <div class="row">
                            <!-- Primera fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" id="dni" name="dni" class="form-control" value="<?php echo htmlspecialchars($usuario['dni']); ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($usuario['email']); ?>" readonly>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Segunda fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($usuario['nombre']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tercera fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección:</label>
                                <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo htmlspecialchars($usuario['direccion']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="localidad" class="form-label">Localidad:</label>
                                <input type="text" id="localidad" name="localidad" class="form-control" value="<?php echo htmlspecialchars($usuario['localidad']); ?>">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Cuarta fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="provincia" class="form-label">Provincia:</label>
                                <input type="text" id="provincia" name="provincia" class="form-control" value="<?php echo htmlspecialchars($usuario['provincia']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control" value="<?php echo htmlspecialchars($usuario['telefono']); ?>">
                            </div>
                        </div>
                                  <!-- Quinta fila con Rol y Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label">Rol:</label>
                                <select id="rol" name="rol" class="form-control">
                                    <option value="0" <?php echo ($usuario['rol'] == 0) ? 'selected' : ''; ?>>0</option>
                                    <option value="1" <?php echo ($usuario['rol'] == 1) ? 'selected' : ''; ?>>1</option>
                                    <option value="2" <?php echo ($usuario['rol'] == 2) ? 'selected' : ''; ?>>2</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">Estado (Activo):</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="activo" name="estado" value="1" <?php echo ($usuario['activo'] == 1) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="activo">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inactivo" name="estado" value="0" <?php echo ($usuario['activo'] == 0) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="inactivo">0</label>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de submit -->
                        <div class="d-flex justify-content-center mt-4 mb-5">
                        <button type="submit" class="btn bg-secondary-custom me-3">Guardar Cambios</button>
                            <a href="gestion_usuarios.php" class="btn bg-secondary-custom">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
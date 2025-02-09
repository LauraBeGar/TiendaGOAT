<?php 
session_start(); 
include '../servidor/seguridadAdmin.php';
include_once '../servidor/mensajes.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta usuario</title>
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
        <?php mostrarMensaje() ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="content p-3">
                    <h2 class="text-center">Dar de alta a nuevos Usuarios</h2>
                    <form action="../servidor/c_crearUsuario.php" method="post">
                        <div class="row">
                            <!-- Primera fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" id="dni" name="dni" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="text" id="email" name="email" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Segunda fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" id="nombre" name="nombre" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellidos" class="form-label">Apellidos:</label>
                                <input type="text" id="apellidos" name="apellidos" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tercera fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección:</label>
                                <input type="text" id="direccion" name="direccion" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="localidad" class="form-label">Localidad:</label>
                                <input type="text" id="localidad" name="localidad" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Cuarta fila con dos columnas -->
                            <div class="col-md-6 mb-3">
                                <label for="provincia" class="form-label">Provincia:</label>
                                <input type="text" id="provincia" name="provincia" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" id="telefono" name="telefono" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Quinta fila con Rol y Estado -->
                            <div class="col-md-6 mb-3">
                                <label for="rol" class="form-label">Rol:</label>
                                <select id="rol" name="rol" class="form-control">
                                    <option>0</option>
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="clave" class="form-label">Contraseña:</label>
                                <input type="password" id="clave" name="clave" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="activo" class="form-label">Estado (Activo):</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="activo" name="activo">
                                    <label class="form-check-label" for="activo">1</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="inactivo" name="activo">
                                    <label class="form-check-label" for="inactivo">0</label>
                                </div>
                            </div>

                            <!-- Botón de submit -->
                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn bg-secondary-custom me-3">Crear Usuario</button>
                                <a href="gestion_usuarios.php" class="btn bg-secondary-custom">Cancelar</a>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <?php include '../plantillas/footer.php' ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
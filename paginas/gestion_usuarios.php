<?php
session_start();

require_once '../servidor/config.php';
include_once '../gestores/GestorUsuarios.php';
include_once '../servidor/mensajes.php';
require_once '../servidor/seguridadAdmin.php';

$db = conectar();
$gestor = new GestorUsuarios($db);
$email = $_SESSION['email'];
$usuario = $gestor->obtener_usuarios();

if (isset($_GET['ordenar']) && $_GET['ordenar'] == 'nombre') {
    $orden = isset($_GET['orden']) && strtolower($_GET['orden']) == 'desc' ? 'DESC' : 'ASC';
    $usuario = $gestor->ordenarUsuariosPorNombre($orden);
} elseif (isset($_GET['buscar'])) {
    $usuario = $gestor->buscarUsuario($_GET['buscar']);
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
    <link rel="stylesheet" href="../estilos/style1.css">
</head>

<body>
    <?php include '../plantillas/header.php' ?>
    <?php include '../plantillas/menuAdmin.php' ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Gestión de Usuarios</h1>
        <?php mostrarMensaje() ?>
        <div class="d-flex ms-auto justify-content-center p-3">
            <form action="gestion_usuarios.php" method="GET" class="d-flex">
                <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar por nombre o DNI">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Buscar</button>
            </form>
            <form action="crear_usuario.php" method="GET">
                <button type="submit" class="btn bg-secondary-custom link-hover-custom me-2">Nuevo usuario</button>
            </form>
            <form action="gestion_usuarios.php" method="GET" class="ms-2">
                <input type="hidden" name="ordenar" value="nombre">
                <input type="hidden" name="orden" value="asc">
                <button type="submit" class="btn btn-warning btn-custom">Ordenar A-Z</button>
            </form>

            <form action="gestion_usuarios.php" method="GET" class="ms-2">
                <input type="hidden" name="ordenar" value="nombre">
                <input type="hidden" name="orden" value="desc">
                <button type="submit" class="btn btn-warning btn-custom">Ordenar Z-A</button>
            </form>
        </div>
        <div class="table-container">
            <table class="table table-striped table-bordered">
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
                        <th>Rol</th>
                        <th>Activo</th>
                        <th class="text-center">Editar</th>
                        <th class="text-center">Dar de Baja</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuario as $usuarios): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuarios->getDni()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getNombre()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getApellidos()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getDireccion()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getLocalidad()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getProvincia()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getTelefono()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getEmail()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getRol()); ?></td>
                            <td><?= htmlspecialchars($usuarios->getActivo() == 1 ? 'Activo' : 'Inactivo'); ?></td>
                            <td class="text-center">
                                <a href="editar_administrador.php?dni=<?= htmlspecialchars($usuarios->getDni()); ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="baja_usuario.php?dni=<?= htmlspecialchars($usuarios->getDni()); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php include '../plantillas/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
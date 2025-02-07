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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark w-100">
        <div class="container-fluid">
            <a class="navbar-brand" href="/paginas/panel_administrador.php">Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item me-3">
                        <a class="text-decoration-none text-color-custom " href="/paginas/gestion_usuarios.php">Gestión de Usuarios</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="text-decoration-none text-color-custom " href="/paginas/gestion_productos.php">Gestión de Productos</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="text-decoration-none text-color-custom " href="/paginas/gestion_categorias.php">Gestión de Categorías</a>
                    </li>
                    </li>
                    <li class="nav-item me-3">
                        <a class="text-decoration-none text-color-custom " href="/paginas/gestion_pedidos.php">Gestión de Pedidos</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="text-decoration-none text-color-custom " href="informes.php">Informes</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="text-decoration-none text-primary-custom" href="../servidor/logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>
</html>
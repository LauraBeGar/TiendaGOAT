<?php
session_start();

require_once '../servidor/seguridad.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes</title>
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
        <div class="row justify-content-center">
            <div class="col-md-10 text-center">
                <h1 class="mt-5 mb-5">Informes</h1>

                <div class="row">
                    <div class="col">
                        <a href="./informe.php?informe=Usuarios activos&tipo=1"
                            class="btn btn-outline-warning text-dark"><strong>Usuarios Activos </strong></a>
                    </div>
                    <div class="col">
                        <a href="./informe.php?informe=Usuarios inactivos&tipo=2"
                            class="btn btn-outline-warning text-dark"><strong>Usuarios Inactivos </strong></a>
                    </div>
                    <div class="col">
                        <a href="./informe.php?informe=Productos inactivos&tipo=3"
                            class="btn btn-outline-warning text-dark"><strong>Productos activos </strong></a>
                    </div>

                    <div class="col">
                        <a href="./informe.php?informe=Productos inactivos&tipo=4"
                            class="btn btn-outline-warning text-dark"><strong>Productos Inactivos </strong></a>
                    </div>
                    <div class="col">
                        <a href="./informe.php?informe=Estados de pedidos&tipo=5"
                            class="btn btn-outline-warning text-dark"><strong>Estados de pedidos </strong></a>
                    </div>
                    <div class="col">
                        <a href="./informe.php?informe=Ordenar por fecha Pedidos&tipo=6"
                            class="btn btn-outline-warning text-dark"><strong>Ordenar por fecha Pedidos </strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
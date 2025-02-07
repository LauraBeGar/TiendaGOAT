<?php
session_start();

require_once '../servidor/seguridadAdmin.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    <?php include_once '../plantillas/header.php' ?>
    <?php include '../plantillas/menuAdmin.php'; ?>


    <div class="container-fluid mt-4 flex-grow-1">
        <div class="row ">
            <div class="col-md-2">
                <?php include '../plantillas/menu.php'; ?>
            </div>

            <div class="col-md-8 text-center">
                <h1 class="mb-4">Informes</h1>

                <div class="row">
                    <div class="col">
                    <a href="./informe.php?informe=Usuarios activos&tipo=1"><strong>Usuarios Activos </strong></a>
                    </div>
                    <div class="col">
                    <a href="./informe.php?informe=Usuarios inactivos&tipo=2"><strong>Usuarios Inactivos </strong></a>
                    </div>
                    <div class="col">
                    <a href="./informe.php?informe=Productos inactivos&tipo=3"><strong>Productos activos </strong></a>
                    </div>
    
                    <div class="col">
                    <a href="./informe.php?informe=Productos inactivos&tipo=4"><strong>Productos Inactivos </strong></a>
                    </div>
                    <div class="col">
                    <a href="./informe.php?informe=Estados de pedidos&tipo=5"><strong>Estados de pedidos </strong></a>
                    </div>
                    <div class="col">
                    <a href="./informe.php?informe=Ordenar por fecha Pedidos&tipo=6"><strong>Ordenar por fecha Pedidos </strong></a>
                    </div>

                </div>

                
            </div>
        </div>
    </div>
    <?php include_once '../plantillas/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
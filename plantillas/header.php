<?php

require_once __DIR__ . '/../gestores/GestorProductos.php';
require_once __DIR__ . '/../servidor/config.php';

$db = conectar();

$gestor = new GestorProductos($db);
if (isset($_GET['buscar'])) {
    $productos = $gestor->buscarProducto($_GET['buscar']);
} 

$numCarrito = isset($_SESSION['carrito'])?count($_SESSION['carrito']) : 0;

?>

    <header class="w-100 bg-white start-0 end-0 ">
        <div class="container-fluid">
            <!-- Fila de alerta superior -->
            <div class="row">
                <div class="alert-top col-12 d-flex justify-content-center bg-dark p-2 text-white">
                    <a href="#" class="link-light text-decoration-none me-3">
                        <i class="fas fa-shipping-fast"></i> 
                        ENVIOS Y ENTREGAS
                    </a>
                </div>
            </div>
            <!-- Fila del header principal -->
            <div class="row align-items-center pt-3 border-bottom border-1 border-dark">
                <!-- Menú -->
                <div class="col-4 d-flex justify-content-start">
                    <nav class="navbar navbar-expand-lg navbar-light bg-white">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="../index.php">HOME</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">PROMOCIONES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">ENVÍO</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">DEVOLUCIONES</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">CONTACTO</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Logo -->
                <div class="col-4 d-flex justify-content-center">
                    <a href="#">
                        <img src="/media/goat_logo.png" alt="Logo GOAT" width="180" height="140">
                    </a>
                </div>
                <!-- Buscador, login y carrito -->
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <!-- Buscador -->
                    <form action="" method="get">
                    <div class="input-group w-75 me-3">
                        <input class="form-control" type="search" name="buscar" placeholder="Buscar producto" aria-label="Buscar">
                        <button class="btn btn-outline-secondary"  type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    </form>
                    <!-- Login -->
                    <a class="nav-link fs-5 me-3" href="/paginas/login.php"
                        aria-label="Usuario">
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <!-- Carrito -->
                    <a class="nav-link fs-5 me-4" href="../paginas/carrito.php" aria-label="Carrito">
                        <i class="fas fa-shopping-cart"></i>
                        <?= $numCarrito?>
                    </a>
                </div>
            </div>
        </div>
    </header>

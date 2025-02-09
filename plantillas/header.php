<?php

require_once __DIR__ . '/../gestores/GestorProductos.php';
require_once __DIR__ . '/../servidor/config.php';


$db = conectar();

$gestor = new GestorProductos($db);
if (isset($_GET['buscar'])) {
    $productos = $gestor->buscarProducto($_GET['buscar']);
}

$numCarrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;

?>

<header class="w-100 bg-white start-0 end-0">
    <div class="container-fluid">
        <!-- Fila de alerta superior -->
        <div class="row">
            <div class="alert-top col-12 d-flex justify-content-center bg-light p-2" style="font-size: 0.8rem;">
                <a href="#" class="link-dark text-decoration-none me-3 text-dark">
                    <i class="fas fa-shipping-fast"></i>
                    ENVIOS Y ENTREGAS
                </a>
            </div>
        </div>
        <!-- Fila del header principal -->
        <div class="row bg-dark align-items-center justify-content-between pt-3 border-bottom border-1 border-light">
            <div class="col-3 d-flex justify-content-center mt-3 mb-3">
                <a href="#">
                    <img src="/media/goat_logo_sin_fondo.png" alt="Logo GOAT" width="150" height="110">
                </a>
            </div>
            <!-- Menú -->
            <div class="col-6 d-flex justify-content-start">
                <nav class="navbar navbar-expand-lg bg-dark">
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
            <!-- Buscador, login y carrito -->
            <div class="col-3 d-flex justify-content-end align-items-center">
                <!-- Buscador -->
                <form action="" method="get" class="d-flex me-3 w-100">
                    <div class="input-group w-100">
                        <?php if(isset ($_GET['catProds'])){?>
                            <input type="hidden" name="catProds" value="<?= $_GET['catProds']?>">
                        <?php } ?>
                        <input class="form-control" type="search" name="buscar" placeholder="Buscar" aria-label="Buscar">
                        <button class="btn btn-outline-secondary text-white" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
                <!-- Login -->
                <a class="nav-link fs-5 me-2 text-white" href="/paginas/login.php" aria-label="Usuario">
                    <i class="fa-solid fa-user"></i>
                </a>
                <!-- Carrito -->
                <a class="nav-link fs-5 text-white d-flex align-items-center me-3" href="../paginas/carrito.php" aria-label="Carrito">
                    <i class="fas fa-shopping-cart me-2"></i> 
                    <span><?= $numCarrito ?></span>
                </a>
            </div>
        </div>
    </div>
</header>



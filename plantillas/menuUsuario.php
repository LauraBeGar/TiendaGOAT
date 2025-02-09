<?php 
if (isset($_SESSION["rol"]) && $_SESSION['rol'] === 0){


?>

<div class="col-md-2 bg-light p-3 text-center">
                <h4>Hola, <?php echo isset($_SESSION['nombre']) ? htmlspecialchars($_SESSION['nombre']) : 'Usuario'; ?>!</h4>
                <div class="links">
                    <div>
                        <a href="cuenta_usuario.php" class="text-decoration-none text-color-custom">Mi Cuenta</a>
                    </div>
                    <div>
                        <a href="pedido_usuario.php" class="text-decoration-none text-color-custom">Mis pedidos</a>
                    </div>
                    <div>
                        <a href="cambiar_clave.php" class="text-decoration-none text-color-custom">Cambiar contraseña</a>
                    </div>
                    <div class="logout mt-3 text-bold">
                        <a href="../servidor/logout.php" class="text-decoration-none text-danger font-weight-bold">Cerrar sesión</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>


 


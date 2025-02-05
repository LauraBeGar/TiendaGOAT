<?php 

session_start();

$codigo = $_GET['codigo'];
$cantidad = $_GET['cantidad'];

foreach ($_SESSION['carrito'] as $index => $item) {
    if ($item['codigo'] === $codigo) {
        if ($item['cantidad'] > 1) {
            $_SESSION['carrito'][$index]['cantidad'] -= 1; 
        } else {
            unset($_SESSION['carrito'][$index]); 
        }
        break;
    }
}

header('Location: /paginas/carrito.php');
exit();
?>

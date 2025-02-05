<?php 
session_start();
if(!isset($_SESSION['carrito'])){
    $_SESSION['carrito'] = [];
}
$codigo = $_GET['codigo'];
$nombre = $_GET['nombre'];
$imagen = $_GET['imagen'];
$precio = $_GET['precio'];
$categoria = $_GET['categoria'];

$encontrado = false;

foreach ($_SESSION['carrito'] as &$item) {
    if ($item['codigo'] === $codigo ) {
        $item['cantidad'] += 1;
        
        $encontrado = true;
        break;
    }

}
unset($item); 

if(!$encontrado){
    $_SESSION['carrito'][] = [
        'codigo' => $codigo,
        'nombre' => $nombre,
        'imagen' => $imagen,
        'precio' => $precio,
        'cantidad' => 1
    ];
}
header('Location: /paginas/carrito.php');
exit();
?>
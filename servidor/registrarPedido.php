<?php
session_start();

require_once '../gestores/GestorPedidos.php';
require_once '../servidor/config.php';

$db = conectar();

$gestor = new GestorPedidos($db);

$ultimoId = $gestor -> ultimoId();
$idPedido = $ultimoId + 1;

$codUsuario = $_SESSION['dni'];

$total = 0;

// hago un foreach para recorrer todos los productos y obtener el total del pedido
foreach($_SESSION['carrito'] as $item){
    $total += $item['precio']*$item['cantidad'];

}

$resultado = $gestor->registrarPedido($codUsuario, $total, $idPedido);

if($resultado){
    foreach($_SESSION['carrito'] as $item){
        $gestor->registrarLineaPedido($idPedido,$item['codigo'], $item['nombre'], $item['cantidad'],$item['precio']);
    
    }

    unset($_SESSION['carrito']);
    // ../compra.php?id='.$idPedido
    echo json_encode("../paginas/gracias.php?mensaje=ok");//Respuesta

}




?>
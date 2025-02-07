<?php
session_start();

include_once '../servidor/config.php';
include_once '../gestores/GestorPedidos.php';

$db = conectar();

$gestor = new GestorPedidos($db);

$estado = $_GET['estado'];
$idPedido = $_GET['pedido'];

$gestor->modificarEstado($idPedido, $estado);
if($_SESSION['rol'] === 0){
    header('Location: ../paginas/pedido_usuario.php');
}else{
header('Location: ../paginas/gestion_pedidos.php');
}
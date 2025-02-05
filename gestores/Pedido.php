<?php
class Pedido {
    private $idPedido;
    private $fecha;
    private $total;
    private $estado;
    private $cod_usuario;
    private $activo;

    // Constructor
    public function __construct($idPedido, $fecha, $total, $estado, $cod_usuario, $activo) {
        $this->idPedido = $idPedido;
        $this->fecha = $fecha;
        $this->total = $total;
        $this->estado = $estado;
        $this->cod_usuario = $cod_usuario;
        $this->activo = $activo;
        
    }

    // Getters y Setters
    public function getidPedido() {
        return $this->idPedido;
    }

    public function setidPedido($idPedido) {
        $this->idPedido = $idPedido;
    }
    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function getCod_usuario() {
        return $this->cod_usuario;
    }

    public function setCod_usuario($cod_usuario) {
        $this->cod_usuario = $cod_usuario;
    }

    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }
}
?>
<?php
class Categoria {
    private $codigo;
    private $nombre;
    private $activo;
    private $codCategoriaPadre;

    // Constructor
    public function __construct($codigo, $nombre, $activo, $codCategoriaPadre) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->activo = $activo;
        $this->codCategoriaPadre = $codCategoriaPadre;
    }

    // Getters y Setters
    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    
    public function getActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
    }

    public function getcodCategoriaPadre() {
        return $this->codCategoriaPadre;
    }

    public function setCodCategoriaPadre($codCategoriaPadre) {
        $this->codCategoriaPadre = $codCategoriaPadre;
    }
}
?>
<?php
class Usuario {
    private $dni;
    private $clave;
    private $nombre;
    private $apellidos;
    private $direccion;
    private $localidad;
    private $provincia;
    private $telefono;
    private $email;
    private $rol;
    private $activo;

    // Constructor para inicializar el usuario
    public function __construct($dni, $clave=null, $nombre, $apellidos, $direccion, $localidad, $provincia, $telefono, $email, $rol, $activo) {
        $this->dni = $dni;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->direccion = $direccion;
        $this->localidad = $localidad;
        $this->provincia = $provincia;
        $this->telefono = $telefono;
        $this->email = $email;
        $this->rol = $rol;
        $this->activo = $activo;
    }
    // Getter y Setter 

        public function getDni() { 
            return $this->dni; }

        public function setDni($dni) { 
            $this->dni = $dni; }
    
        public function getClave() { 
            return $this->clave; }

        public function setClave($clave) { 
            $this->clave = $clave; }
    
        public function getNombre() { 
            return $this->nombre; }

        public function setNombre($nombre) { 
            $this->nombre = $nombre; }
    
        public function getApellidos() { 
            return $this->apellidos; }

        public function setApellidos($apellidos) { 
            $this->apellidos = $apellidos; }
    
        public function getDireccion() { 
            return $this->direccion; }

        public function setDireccion($direccion) { 
            $this->direccion = $direccion; }
    
        public function getLocalidad() { 
            return $this->localidad; }

        public function setLocalidad($localidad) {
             $this->localidad = $localidad; }
    
        public function getProvincia() { 
            return $this->provincia; }

        public function setProvincia($provincia) { 
            $this->provincia = $provincia; }
    
        public function getTelefono() { 
            return $this->telefono; }

        public function setTelefono($telefono) { 
            $this->telefono = $telefono; }
    
        public function getEmail() { 
            return $this->email; }

        public function setEmail($email) { 
            $this->email = $email; }
    
        public function getRol() { 
            return $this->rol; }

        public function setRol($rol) { 
            $this->rol = $rol; }

        public function getActivo() { 
            return $this->activo; 
        }

        public function setActivo($activo) { 
            $this->activo = $activo; 
        }
    }
    
?>
<?php
require_once 'Categoria.php';
class GestorCategorias{
    private $db;
    public function __construct($db){
        $this ->db = $db;
        
    }

    public function crearCategoria ($codigo, $nombreCategoria, $activo, $codCategoriaPadre){
        
        $sql = "INSERT into categorias (codigo, nombre, activo, codCategoriaPadre) values (:codigo, :nombre, :activo, :codCategoriaPadre)";

        try{
            $stmt=$this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombreCategoria, PDO::PARAM_STR);
            $stmt->bindParam(':activo', $activo);
            $stmt->bindParam(':codCategoriaPadre', $codCategoriaPadre, PDO::PARAM_STR);

            return $stmt -> execute();
        }catch(PDOException $e){
            echo "Error al crear la categoria: " . $e->getMessage();
            return false;

        }
    }

    public function editarCategoria(Categoria $categoria) {
        $sql = "UPDATE categorias 
                SET nombre = :nombre, 
                    activo = :activo, 
                    codCategoriaPadre = :codCategoriaPadre 
                WHERE codigo = :codigo";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $categoria->getCodigo(), PDO::PARAM_INT);
            $stmt->bindValue(':nombre', $categoria->getNombre());
            $stmt->bindValue(':activo', $categoria->getActivo(), PDO::PARAM_INT);
            $stmt->bindValue(':codCategoriaPadre', $categoria->getCodCategoriaPadre(), PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error al editar categoría: " . $e->getMessage());
            return false;
        }
    }

    public function obtenerCategorias(){
        $sql = "SELECT * FROM categorias";
    
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
    
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $lista_categorias = [];
            foreach ($categorias as $categoria) {
                $lista_categorias[] = new Categoria(
                    
                 $categoria['codigo'],
                 $categoria['nombre'],
                 $categoria['activo'],
                 $categoria['codCategoriaPadre'],
                 
                );}
    
            return $lista_categorias;
    
        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return false;
            }
        }

    // Obtener categoría por código
    public function getCategoriaPorCodigo($codigo) {
        $sql = "SELECT * FROM categorias WHERE codigo = :codigo";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $stmt->execute();

            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($categoria) {
                return new Categoria(
                    $categoria['codigo'],
                    $categoria['nombre'],
                    $categoria['activo'],
                    $categoria['codCategoriaPadre']
                );
            }

            return null;
        } catch (PDOException $e) {
            error_log("Error al obtener categoría: " . $e->getMessage());
            return null;
        }
    }

    public function buscarCategoria ($busqueda){
        $sql = "SELECT codigo, nombre, activo, codCategoriaPadre  FROM categorias WHERE nombre LIKE :busqueda OR codigo LIKE :busqueda";
        try {
            $stmt = $this->db->prepare($sql);
            $param = "%" . $busqueda . "%";
            $stmt->bindParam(':busqueda', $param);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $categorias = [];
            foreach ($result as $row) {
                $categorias[] = new Categoria($row['codigo'], $row['nombre'], $row['activo'], $row['codCategoriaPadre']);
            }
    
            return $categorias;
    
        } catch (PDOException $e) {
            echo "Error al buscar el producto: " . $e->getMessage();
            return [];
        }
    }

    public function bajaCategoria($codigo) {
        $sql = "UPDATE categorias SET activo = 0 WHERE codigo = :codigo";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al dar de baja la categoría: " . $e->getMessage();
            return false;
        }
    }

    public function obtenerCategoriasActivas() {
        $sql = "SELECT * FROM categorias WHERE activo = 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $categorias = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categorias[] = new Categoria(
                    $row['codigo'],
                    $row['nombre'],
                    $row['activo'],
                    $row['codCategoriaPadre']
                );
            }

            return $categorias;
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }

    public function getCategoriasPag($inicio, $cantidad){
        $sql = "SELECT * FROM categorias LIMIT :inicio, :cantidad";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':inicio', (int) $inicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidad', (int) $cantidad, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $categorias = [];
            foreach ($result as $row) {
                $categorias[] = new Categoria(
                    $row['codigo'],
                    $row['nombre'],
                    $row['activo'],
                        $row['codCategoriaPadre'],
                    
                );
            }
            return $categorias;
        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return [];
        }  
    }
    public function getCategoriaPadres(){
        $sql = "SELECT * FROM categorias WHERE codCategoriaPadre = 0 AND activo = 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }

    
    public function getCategoriaHijos($codPadre){
        $sql = "SELECT * FROM categorias WHERE codCategoriaPadre = :codigo AND activo = 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codPadre);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }

    //esta consulata es para seleccionar una categoria hijo para un producto
    public function getOptionCategoria(){
        $sql = "SELECT * FROM categorias WHERE codCategoriaPadre != 0 AND activo = 1";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }

    public function getCategoriaNombre($codigo){
        $sql = "SELECT nombre FROM categorias WHERE codigo = :codigo";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo',$codigo);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error al obtener categorías: " . $e->getMessage());
            return [];
        }
    }
    
}

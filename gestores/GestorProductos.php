<?php
require_once 'Producto.php';
class GestorProductos
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;

    }


    public function obtenerProductos()
    {
        $sql = "SELECT * FROM productos";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lista_productos = [];
            foreach ($productos as $producto) {
                $lista_productos[] = new Producto(

                    $producto['codigo'],
                    $producto['nombre'],
                    $producto['descripcion'],
                    $producto['imagen'],
                    $producto['categoria'],
                    $producto['precio'],
                    $producto['activo'],
                );
            }

            return $lista_productos;

        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return false;
        }
    }

    

    public function getProductoPorCodigo($codigo)
    {
        $sql = "SELECT * FROM productos WHERE codigo = :codigo";

        try {

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();


            if ($stmt->rowCount() > 0) {

                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {

                return false;
            }
        } catch (PDOException $e) {
            //
            return "Error al obtener el producto: " . $e->getMessage();
        }
    }


    public function registrar(Producto $producto)
    {
        $sql = "INSERT INTO productos (codigo, nombre, descripcion, imagen, categoria, precio, activo) 
                        VALUES (:codigo, :nombre, :descripcion, :imagen, :categoria, :precio, :activo)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':codigo', $producto->getCodigo());
            $stmt->bindValue(':nombre', $producto->getNombre());
            $stmt->bindValue(':descripcion', $producto->getDescripcion());
            $stmt->bindValue(':imagen', $producto->getImagen());
            $stmt->bindValue(':categoria', $producto->getCategoria());
            $stmt->bindValue(':precio', $producto->getPrecio());
            $stmt->bindValue(':activo', $producto->getActivo());

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return 'Error al registrar el artículo: ' . $e->getMessage();

        }
    }

    public function bajaProducto($codigo)
    {
        $sql = "UPDATE productos SET activo = 0 WHERE codigo = :codigo";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al dar de baja la categoría: " . $e->getMessage();
            return false;
        }
    }
    public function getProductosPag($inicio, $cantidad, $orden)
    {
        $sql = "SELECT * FROM productos order by precio $orden LIMIT :inicio, :cantidad";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':inicio', (int) $inicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidad', (int) $cantidad, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            foreach ($result as $row) {
                $productos[] = new Producto(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['imagen'],
                    $row['categoria'],
                    $row['precio'],
                    $row['activo']

                );
            }
            return $productos;
        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return [];
        }
    }
    public function getProductosPagActivos($inicio, $cantidad, $orden)
    {
        $sql = "SELECT * FROM productos WHERE activo = 1 order by precio $orden LIMIT :inicio, :cantidad";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':inicio', (int) $inicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidad', (int) $cantidad, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            foreach ($result as $row) {
                $productos[] = new Producto(
                    $row['codigo'],
                    $row['nombre'],
                    $row['descripcion'],
                    $row['imagen'],
                    $row['categoria'],
                    $row['precio'],
                    $row['activo']

                );
            }
            return $productos;
        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return [];
        }
    }

    public function editar(Producto $producto)
    {
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion,  imagen = :imagen,
            categoria = :categoria, precio = :precio, activo = :activo
            WHERE codigo = :codigo";

        try {
            $stmt = $this->db->prepare($sql);

            $codigo = $producto->getCodigo();
            $nombre = $producto->getNombre();
            $descripcion = $producto->getDescripcion();
            $imagen = $producto->getImagen();
            $categoria = $producto->getCategoria();
            $precio = $producto->getPrecio();
            $activo = $producto->getActivo();

            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindValue(':categoria', $categoria);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':activo', $activo);


            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $e) {
            error_log("Error al editar artículo: " . $e->getMessage());
            return false;
        }
    }

    public function ordenarProductoPorNombre($orden)
    {
        $orden = strtoupper($orden) === 'DESC' ? 'DESC' : 'ASC';
        $sql = "SELECT codigo, nombre, descripcion, imagen, categoria, precio, activo FROM productos ORDER BY nombre $orden";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            foreach ($result as $row) {
                $productos[] = new Producto($row['codigo'], $row['nombre'], $row['descripcion'], $row['imagen'], $row['categoria'], $row['precio'], $row['activo']);
            }

            return $productos;

        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return [];
        }
    }


    public function buscarProducto($busqueda)
    {
        $sql = "SELECT codigo, nombre, descripcion, imagen, categoria, precio, activo FROM productos WHERE nombre LIKE :busqueda OR codigo LIKE :busqueda";
        try {
            $stmt = $this->db->prepare($sql);
            $param = "%" . $busqueda . "%";
            $stmt->bindParam(':busqueda', $param);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $productos = [];
            foreach ($result as $row) {
                $productos[] = new Producto($row['codigo'], $row['nombre'], $row['descripcion'], $row['imagen'], $row['categoria'], $row['precio'], $row['activo']);
            }

            return $productos;

        } catch (PDOException $e) {
            echo "Error al buscar el producto: " . $e->getMessage();
            return [];
        }
    }

    public function getProductosPorCategoria($codCategoria, $orden)
    {
        $sql = "SELECT * FROM productos WHERE categoria = :categoria AND activo = 1 order by precio $orden";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':categoria', $codCategoria);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Error al obtener el producto: " . $e->getMessage();
        }
    }

    public function obtenerProductosEstado($estado)
    {
        $sql = "SELECT * FROM productos WHERE activo = :estado";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return false;
        }
    }

    



}
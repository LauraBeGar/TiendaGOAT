<?php
include_once 'Pedido.php';
class GestorPedidos
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Registrar un nuevo pedido
    public function registrarPedido($cod_usuario, $total, $idPedido)
    {
        try {
            $sql = "INSERT INTO pedidos (fecha, total, cod_usuario, idPedido) 
                    VALUES (CURDATE(), :total, :cod_usuario, :idPedido)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':cod_usuario', $cod_usuario);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function registrarLineaPedido($num_pedido, $cod_producto, $nombre_producto, $cantidad, $precio)
    {
        try {
            $sql = "INSERT INTO linea_pedido (num_pedido, cod_producto, nombre_producto, cantidad, precio) 
                    VALUES (:num_pedido, :cod_producto, :nombre_producto, :cantidad, :precio)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':num_pedido', $num_pedido, PDO::PARAM_INT);
            $stmt->bindParam(':cod_producto', $cod_producto, PDO::PARAM_STR);
            $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmt->bindParam(':precio', $precio, PDO::PARAM_STR);
            $stmt->bindParam(':nombre_producto', $nombre_producto, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function ultimoId()
    {
        try {
            $sql = "SELECT idPedido FROM pedidos order by idPedido DESC LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado ? $resultado['idPedido'] : 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }

    }


    // Modificar el estado de un pedido
    public function modificarEstado($idPedido, $estado)
    {
        try {
            $sql = "UPDATE pedidos SET estado = :estado WHERE idPedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Cancelar un pedido (activo = 0)
    public function cancelarPedido($idPedido)
    {
        try {
            $sql = "UPDATE pedidos SET activo = 0 WHERE idPedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Obtener un pedido por su ID
    public function obtenerPedido($idPedido)
    {
        try {
            $sql = "SELECT * FROM pedidos WHERE idPedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function buscarPedido($busqueda)
    {
        $sql = "SELECT idPedido, fecha, total, estado, cod_usuario  FROM pedidos WHERE idPedido LIKE :busqueda";
        try {
            $stmt = $this->db->prepare($sql);
            $param = "%" . $busqueda . "%";
            $stmt->bindParam(':busqueda', $param);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $pedidos = [];
            foreach ($result as $row) {
                $pedidos[] = new Pedido(
                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['cod_usuario']
                );

            }

            return $pedidos;

        } catch (PDOException $e) {
            echo "Error al buscar el producto: " . $e->getMessage();
            return [];
        }
    }
    // Obtener todos los pedidos de un usuario
    public function obtenerPedidosUsuario($cod_usuario)
    {
        try {
            $sql = "SELECT * FROM pedidos WHERE cod_usuario = :cod_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cod_usuario', $cod_usuario);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $pedidos = [];
            foreach ($result as $row) {
                $pedidos[] = new Pedido(
                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['cod_usuario']
                );
            }
            return $pedidos;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    

    public function obtenerLineasPedidos($idPedido)
    {
        try {
            $sql = "SELECT * FROM linea_pedido WHERE num_pedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Listar todos los pedidos
    public function listarPedidos()
    {
        try {
            $sql = "SELECT * FROM pedidos";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function obtenerPedidos()
    {
        $sql = "SELECT * FROM pedidos";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lista_pedidos = [];
            foreach ($result as $row) {
                $lista_categorias[] = new Pedido(

                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['cod_usuario']

                );
            }

            return $lista_categorias;

        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return false;
        }
    }

    public function listarPedidosEstado($estado)
    {
        try {
            $sql = "SELECT * FROM pedidos WHERE estado = :estado";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }


    public function obtenerPedidosFecha($orden)
    {
        $sql = "SELECT * FROM pedidos order by fecha $orden";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return false;
        }
    }

    public function getPedidosPag($inicio, $cantidad)
    {
        $sql = "SELECT * FROM pedidos LIMIT :inicio, :cantidad";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':inicio', (int) $inicio, PDO::PARAM_INT);
            $stmt->bindValue(':cantidad', (int) $cantidad, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $pedidos = [];
            foreach ($result as $row) {
                $pedidos[] = new Pedido(
                    $row['idPedido'],
                    $row['fecha'],
                    $row['total'],
                    $row['estado'],
                    $row['cod_usuario'],


                );
            }
            return $pedidos;
        } catch (PDOException $e) {
            echo "Error al obtener los productos: " . $e->getMessage();
            return [];
        }
    }

}
?>
<?php
class GestorPedidos {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Registrar un nuevo pedido
    public function registrarPedido($cod_usuario, $total) {
        try {
            $sql = "INSERT INTO pedidos (fecha, total, estado, cod_usuario, activo) 
                    VALUES (CURDATE(), :total, 1, :cod_usuario, 1)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':cod_usuario', $cod_usuario);
            $stmt->execute();
            return $this->db->lastInsertId(); // Retorna el ID del nuevo pedido
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Modificar el estado de un pedido (ej. confirmado, en proceso, enviado)
    public function modificarEstado($idPedido, $estado) {
        try {
            $sql = "UPDATE pedidos SET estado = :estado WHERE idPedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->rowCount() > 0; // Si se actualizó correctamente, retorna true
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Cancelar un pedido (activo = 0)
    public function cancelarPedido($idPedido) {
        try {
            $sql = "UPDATE pedidos SET activo = 0 WHERE idPedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->rowCount() > 0; // Si se canceló correctamente, retorna true
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Obtener un pedido por su ID
    public function obtenerPedido($idPedido) {
        try {
            $sql = "SELECT * FROM pedidos WHERE idPedido = :idPedido";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':idPedido', $idPedido);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna los datos del pedido
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Obtener todos los pedidos de un usuario
    public function obtenerPedidosUsuario($cod_usuario) {
        try {
            $sql = "SELECT * FROM pedidos WHERE cod_usuario = :cod_usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cod_usuario', $cod_usuario);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los pedidos del usuario
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    // Listar todos los pedidos
public function listarPedidos() {
    try {
        $sql = "SELECT * FROM pedidos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los pedidos
    } catch (PDOException $e) {
        return "Error: " . $e->getMessage();
    }
}
}
?>
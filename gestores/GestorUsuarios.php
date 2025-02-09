<?php
require_once 'Usuario.php';
class GestorUsuarios
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function validarDni($dni)
    {

        if (preg_match('/^[0-9]{8}[A-Z]$/', $dni)) {
            $numero = substr($dni, 0, 8);
            $letra = substr($dni, -1);
            $letras_validas = "TRWAGMYFPDXBNJZSQVHLCKE";

            $indice = $numero % 23;

            return $letras_validas[$indice] === $letra;
        }
        return false;
    }

    public function validarEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return preg_match('/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/', $email);
    }

    public function email_existe($email)
    {
        $sql = "SELECT email FROM usuarios WHERE email = :email";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error al verificar el email: " . $e->getMessage();
            return false;
        }
    }

    public function comprobarDni($dni)
    {
        $sql = "select dni from usuarios where dni = :dni";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                return $usuario['dni'];
            }

            return null;

        } catch (PDOException $e) {
            die("error en la consulta " . $e->getMessage());

        }
    }

    public function obtener_clave_db($email, $clave)
    {
        $sql = "SELECT clave FROM usuarios WHERE email = :email";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $clave_hash = $usuario['clave'];

                return password_verify($clave, $clave_hash);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error al obtener la clave de la base de datos: " . $e->getMessage();
            return false;
        }
    }

    public function registrar_usuario(Usuario $usuario)
    {

        $dni = $usuario->getDni();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $rol = $usuario->getRol();
        $activo = $usuario->getActivo();
        $clave = password_hash($usuario->getClave(), PASSWORD_DEFAULT);

        if (!$this->validarDni($dni)) {
            header("Location: ../paginas/registro.php?error=El DNI no es válido");
            exit();
        }

        if (!$this->validarEmail($email)) {
            header("Location: ../paginas/registro.php?error=El email no es válido");
            exit();
        }

        //comprobar si el dni ya existe
        if ($this->comprobarDni($dni)) {
            header("Location: ../paginas/registro.php?error=El DNI ya está registrado");
            exit();
        }

        if ($this->email_existe($email)) {
            header("Location: ../paginas/registro.php?error=El email ya está registrado");
            exit();
        }

        $sql = "INSERT INTO usuarios (dni, nombre, apellidos, email, rol, activo, clave, direccion, localidad, provincia, telefono) 
        VALUES (:dni, :nombre, :apellidos, :email, :rol, :activo, :clave, '', '', '', '')";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dni', $dni);
            $stmt->bindValue(':nombre', $nombre);
            $stmt->bindValue(':apellidos', $apellidos);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':rol', $rol);
            $stmt->bindValue(':activo', $activo);
            $stmt->bindValue(':clave', $clave);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                header("Location: ../paginas/login.php?mensaje=¡Registrado! Ya puedes iniciar sesión.");
                exit();
            } else {
                return "Error al insertar los valores.";
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function crear_usuario(Usuario $usuario)
    {

        $dni = $usuario->getDni();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $direccion = $usuario->getDireccion();
        $localidad = $usuario->getLocalidad();
        $provincia = $usuario->getProvincia();
        $telefono = $usuario->getTelefono();
        $email = $usuario->getEmail();
        $rol = $usuario->getRol();
        $activo = $usuario->getActivo();
        $clave = $usuario->getClave();

        if (!$this->validarDni($dni)) {
            header("Location: ../paginas/crear_usuario.php?error=El DNI no es válido");
            exit();
        }

        if ($this->comprobarDni($dni)) {
            header("Location: ../paginas/crear_usuario.php?error=El DNI ya está registrado");
            exit();
        }

        if ($this->email_existe($email)) {
            header("Location: ../paginas/login.php?error=El email ya está registrado");
            exit();
        }

        $sql = "INSERT INTO usuarios (dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, clave, rol, activo) 
                VALUES (:dni, :nombre, :apellidos, :direccion, :localidad, :provincia, :telefono, :email, :clave, :rol, :activo)";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':dni', $dni);
            $stmt->bindValue(':nombre', $nombre);
            $stmt->bindValue(':apellidos', $apellidos);
            $stmt->bindValue(':direccion', $direccion);
            $stmt->bindValue(':localidad', $localidad);
            $stmt->bindValue(':provincia', $provincia);
            $stmt->bindValue(':telefono', $telefono);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':rol', $rol);
            $stmt->bindValue(':activo', $activo);
            $stmt->bindValue(':clave', $clave);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function login($email, $clave)
    {
        $sql = "SELECT email, dni, nombre, clave, rol, activo FROM usuarios WHERE email = :email";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                $clave_hash = $usuario['clave'];

                if ($usuario['activo'] == 0) {
                    header('Location: ../paginas/login.php?error=usuario inactivo');
                    exit();
                }

                if (password_verify($clave, $clave_hash)) {
                    return $usuario;
                } else {
                    header('Location: ../paginas/login.php?error=Contraseña incorrecta');
                    exit();
                }
            } else {
                header('Location: ../paginas/login.php?error=No hay usuarios registrados con ese email');
                exit();
            }
        } catch (PDOException $e) {
            echo "Error en el inicio de la sesión: " . $e->getMessage();
            return false;
        }
    }

    public function obtener_datos_usuario($email)
    {
        $sql = "SELECT dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, rol, activo FROM usuarios WHERE email = :email";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los datos del usuario: " . $e->getMessage();
            return false;
        }
    }

    public function obtener_datos_dni($dni)
    {
        $sql = "SELECT * FROM usuarios WHERE dni = :dni";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los datos del usuario: " . $e->getMessage();
            return false;
        }
    }

    public function cambiar_clave($email, $nueva_clave)
    {
        $nueva_clave = password_hash($nueva_clave, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET clave = :clave WHERE email = :email";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':clave', $nueva_clave, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al cambiar la contraseña: " . $e->getMessage();
            return false;
        }
    }

    public function actualizar_datos_usuario(Usuario $usuario)
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, direccion = :direccion, localidad = :localidad, provincia = :provincia, telefono = :telefono, email = :email, rol = :rol, activo = :activo WHERE dni = :dni";

        try {
            $stmt = $this->db->prepare($sql);

            // Almacena los valores en variables antes de pasarlos
            $dni = $usuario->getDni();
            $nombre = $usuario->getNombre();
            $apellidos = $usuario->getApellidos();
            $direccion = $usuario->getDireccion();
            $localidad = $usuario->getLocalidad();
            $provincia = $usuario->getProvincia();
            $telefono = $usuario->getTelefono();
            $email = $usuario->getEmail();
            $rol = $usuario->getRol();
            $activo = $usuario->getActivo();

            // Ahora pasa las variables a bindParam
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellidos', $apellidos, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':localidad', $localidad, PDO::PARAM_STR);
            $stmt->bindParam(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_INT);
            $stmt->bindParam(':activo', $activo, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al actualizar los datos del usuario: " . $e->getMessage();
            return false;
        }
    }

    public function bajaUsuario($dni)
    {
        $sql = "UPDATE usuarios SET activo = 0 WHERE dni = :dni";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error al dar de baja la categoría: " . $e->getMessage();
            return false;
        }
    }

    public function obtener_usuarios()
    {
        $sql = "SELECT dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, rol, activo FROM usuarios";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $lista_usuarios = [];
            foreach ($usuarios as $usuario) {
                $lista_usuarios[] = new Usuario(
                    $usuario['dni'],
                    $usuario['nombre'],
                    $usuario['apellidos'],
                    $usuario['direccion'],
                    $usuario['localidad'],
                    $usuario['provincia'],
                    $usuario['telefono'],
                    $usuario['email'],
                    $usuario['rol'],
                    $usuario['activo']
                );
            }

            return $lista_usuarios;
        } catch (PDOException $e) {
            echo "Error al obtener los clientes: " . $e->getMessage();
            return [];
        }
    }

    public function ordenarUsuariosPorNombre($orden)
    {
        $orden = strtoupper($orden) === 'DESC' ? 'DESC' : 'ASC';
        $sql = "SELECT dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, rol, activo FROM usuarios ORDER BY nombre $orden";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $usuarios = [];
            foreach ($result as $row) {
                $usuarios[] = new Usuario($row['dni'], "", $row['nombre'], $row['apellidos'], $row['direccion'], $row['localidad'], $row['provincia'], $row['telefono'], $row['email'], $row['rol'], $row['activo']);
            }

            return $usuarios;

        } catch (PDOException $e) {
            echo "Error al obtener los usuarios: " . $e->getMessage();
            return [];
        }
    }

    public function buscarUsuario($busqueda)
    {
        $sql = "SELECT dni, nombre, apellidos, direccion, localidad, provincia, telefono, email, rol, activo FROM usuarios WHERE nombre LIKE :busqueda OR dni LIKE :busqueda";
        try {
            $stmt = $this->db->prepare($sql);
            $param = "%" . $busqueda . "%";
            $stmt->bindParam(':busqueda', $param);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $usuarios = [];
            foreach ($result as $row) {
                $usuarios[] = new Usuario($row['dni'], "", $row['nombre'], $row['apellidos'], $row['direccion'], $row['localidad'], $row['provincia'], $row['telefono'], $row['email'], $row['rol'], $row['activo']);
            }

            return $usuarios;

        } catch (PDOException $e) {
            echo "Error al buscar el usuario: " . $e->getMessage();
            return [];
        }
    }


    public function restablecerClave($email, $clave)
    {
        $sql = "UPDATE usuarios SET clave = :clave WHERE email = :email";

        $claveHash = password_hash($clave, PASSWORD_DEFAULT);

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':clave', $claveHash, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log("Error al cambiar la contraseña: " . $e->getMessage());
            return false;
        }
    }
    public function completarInfo($dni, $direccion, $localidad, $provincia, $telefono)
    {

        $sql = "UPDATE usuarios SET direccion = :direccion, localidad = :localidad, 
        provincia = :provincia, telefono = :telefono WHERE dni = :dni";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
            $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
            $stmt->bindParam(':localidad', $localidad, PDO::PARAM_STR);
            $stmt->bindParam(':provincia', $provincia, PDO::PARAM_STR);
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);

            return $stmt->execute();


        } catch (PDOException $e) {
            echo 'error al completar la informacion' . $e->getMessage();
            return false;

        }
    }

    public function obtener_usuarios_estado($estado) {
        $sql = "SELECT dni, nombre, apellidos, telefono, email FROM usuarios WHERE activo = :estado";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener los clientes: " . $e->getMessage();
            return [];
        }
    }

}


























?>
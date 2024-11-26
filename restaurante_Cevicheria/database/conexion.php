<?php
date_default_timezone_set('America/Lima'); // Establece la zona horaria a Perú Lima
class Conexion {
    private $con;

    public function __construct() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $bd = "bdrescevicheria";

        // Crear la conexión
        $this->con = new mysqli($host, $user, $pass, $bd);

        if ($this->con->connect_error) {
            die("Conexión fallida: " . $this->con->connect_error);
        }
    }

    public function getConexion() {
        return $this->con;
    }

    public function cerrarConexion() {
        return $this->con->close();
    }

        //reclamos
        public function Mostrar_Reclamaciones(){
            $sql='SELECT
            r.id,
            u.correo,
            r.telefono,
            r.asunto,
            r.descripcion,
            r.respuesta,
            r.estado,
            r.fecha_reclamo
            FROM tbreclamos r JOIN tbusuario u 
            ON r.usuario_id = u.id 
            ORDER BY r.estado ASC';
            $resultado =$this->con->query($sql);
            $reclamo = array();
            while($row = $resultado->fetch_assoc()){
                $reclamo[]=$row;
            }
            return $reclamo;
        }
    
        public function insertReclamaciones($usuario_id, $telefono, $asunto, $descripcion)
        {
            $sql = "INSERT INTO tbreclamos (usuario_id, telefono, asunto, descripcion, fecha_reclamo, estado) VALUES (?, ?, ?, ?, current_timestamp(), 'Pendiente')";
            $stmt = $this->con->prepare($sql);
    
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($this->con->error));
            }

            $stmt->bind_param('isss', $usuario_id, $telefono, $asunto, $descripcion);
            if ($stmt->execute() === false) {
                die('Execute failed: ' . htmlspecialchars($stmt->error));
            }
    
            $stmt->close();
        }
    
        public function leer_reclamo($id){
            $sql = "UPDATE tbreclamos SET estado = 'En proceso' WHERE id='$id'";
            $this->con->query($sql);
        }
        public function edit_reclamo($id,$respuesta,$estado){
            $sql = "UPDATE tbreclamos SET respuesta='$respuesta', estado ='$estado' WHERE id='$id'";
            $this->con->query($sql);
        }

        public function ReclamosCod($id){
            $sql="SELECT
            r.id,
            u.correo,
            r.telefono,
            r.asunto,
            r.descripcion,
            r.respuesta,
            r.estado,
            r.fecha_reclamo
            FROM tbreclamos r LEFT JOIN tbusuario u 
            ON r.usuario_id = u.id 
            WHERE r.id='$id' ORDER BY r.estado ASC";
            $result = $this->con->query($sql);
            $reclamo = array();
    
            while($row = $result->fetch_assoc()){
                $reclamo[] = $row;
            }
            
            return $reclamo;
        }

        //gestion usuarios
    public function Mostrar_Usuarios($rol_id){
        $sql="SELECT * FROM tbusuario WHERE cargo_id = $rol_id";
        $resultado =$this->con->query($sql);
        $usuarios = array();
        while($row = $resultado->fetch_assoc()){
            $usuarios[]=$row;
        }
    return $usuarios;
    }

    // Usuarios (Activar y Desactivar)

    public function Cambiar_Rol($id, $rol_id){
        $sql = "UPDATE tbusuario SET cargo_id = $rol_id WHERE id = $id";
        $this->con->query($sql);
    }

    //insertar usuario cuando se registra
    public function insertUser($nombre, $apellidos, $dni, $correo, $contrasenia, $genero, $fechaNacimiento)
    {
        $sql = "INSERT INTO tbusuario (nombre, apellidos, dni, correo, contrasenia, cargo_id, genero, fechaNacimiento) VALUES (?, ?, ?, ?, ?, 2, ?, ?)";
        
        $stmt = $this->con->prepare($sql);
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $this->con->error);
        }
        $stmt->bind_param("sssssss", $nombre, $apellidos, $dni, $correo, $contrasenia, $genero, $fechaNacimiento);
        if ($stmt->execute()) {
            $last_id = $this->con->insert_id;
            $stmt->close();
            return $last_id;
        } else {
            echo "Error al insertar el usuario: " . $stmt->error;
            return false;
        }
    }
    // Verificar el email y te se actualiza a 1 la activacion
    public function verifyToken($token) {
        $sql = "SELECT id, token_verificacion_expira FROM tbusuario WHERE token_verificacion = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->bind_result($id, $expira);
        $stmt->fetch();
        if ($id && new DateTime($expira) > new DateTime()) {
            return $id;
        }
        return false;
    }
    

    public function verifyEmail($usuario_id) {
        $sql = "UPDATE tbusuario SET verificado = 1, token_verificacion = NULL, token_verificacion_expira = NULL WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        return $stmt->execute();
    }

    public function isEmailRegistered($correo) {
        $sql_check = "SELECT * FROM tbusuario WHERE correo = '$correo'";
        $result = $this->con->query($sql_check);
        return $result->num_rows > 0;
    }
    
    public function saveVerificationToken($usuario_id, $token, $expira) {
        $sql = "UPDATE tbusuario SET token_verificacion = ?, token_verificacion_expira = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ssi", $token, $expira, $usuario_id);
        return $stmt->execute();
    }


        //traer ids de usuarios 
        public function getPersonaByUserId($user_id) {
            $sql = "SELECT nombre, apellidos, dni, correo, genero, fechaNacimiento FROM tbusuario WHERE id = ?";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function getUserDetails($user_id) {
            $sql = "SELECT * FROM tbusuario WHERE id = ?";
            $stmt = $this->con->prepare($sql);
        
            if ($stmt === false) {
                throw new Exception("Error al preparar la consulta: " . $this->con->error);
            }
        
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if ($result->num_rows == 1) {
                return $result->fetch_assoc();
            } else {
                return null;
            }
        }

    public function getUserRole($email) {
        $query = "SELECT rol_id FROM usuarios WHERE email = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row ? $row['rol_id'] : null;
    }


    public function getLastInsertedUserId($email) {
        $sql = "SELECT id FROM usuarios WHERE email = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        return $id;
    }

    public function isEmailVerified($email) {
        $sql = "SELECT verificado FROM tbusuario WHERE correo = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($verificado);
        $stmt->fetch();
        $stmt->close();
        return $verificado == 1;
    }

    public function loginUser($email, $contraseña)
    {
        $sql = "SELECT * FROM tbusuario WHERE correo = '$email'";
        $result = $this->con->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($contraseña, $user['contrasenia'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nombre'] = $user['nombre'];
                $_SESSION['user_correo'] = $user['correo'];
                $_SESSION['user_cargo_id'] = $user['cargo_id'];
                return true;
            }
        }
        return false;
    }

    public function validateResetToken($email, $token) {
        $current_time = time();
        $stmt = $this->con->prepare("SELECT * FROM tbreset_tokens WHERE correo = ? AND token = ? AND timestamp >= ?");
        $stmt->bind_param('ssi', $email, $token, $current_time);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    //eliminar el token cuando se actualize
    public function deletePasswordResetToken($email) {
        $stmt = $this->con->prepare("DELETE FROM tbreset_tokens  WHERE correo = ?");
        $stmt->bind_param('s', $email);
        return $stmt->execute();
    }

    public function savePasswordResetToken($email, $token) {
        $this->deletePasswordResetToken($email);

        $timestamp = time() + 45 * 60; 
        $stmt = $this->con->prepare("INSERT INTO tbreset_tokens (token, timestamp, correo) VALUES (?, ?, ?)");
        $stmt->bind_param('sis', $token, $timestamp, $email);
        return $stmt->execute();
    }
    public function updateEmail($user_id, $email) {
        $query = "UPDATE tbusuario SET correo = ? WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('si', $email, $user_id);
        return $stmt->execute();
    }
    public function updateVerifiedEmail($user_id) {
        $query = "UPDATE tbusuario SET verificado = NULL WHERE id = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('i', $user_id);
        return $stmt->execute();
    }
    public function updateUserPasswordById($usuario_id, $newPassword) {
        $stmt = $this->con->prepare("UPDATE tbusuario SET contrasenia = ? WHERE id = ?");
        $stmt->bind_param('si', $newPassword, $usuario_id);
        return $stmt->execute();
    }

    //restablecer contrasena
    public function updateUserPassword($email, $newPassword) {
        $stmt = $this->con->prepare("UPDATE tbusuario SET contrasenia = ? WHERE correo = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $this->con->error);
        }    
        $stmt->bind_param('ss', $newPassword, $email);
        return $stmt->execute();
    }
    
    //extraer el nombre para mostrarlo
    public function getNombreByUserId($user_id) {
        $sql = "SELECT nombre FROM tbusuario WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getReclamosByUserId($user_id) {
        $stmt = $this->con->prepare("SELECT * FROM tbreclamos WHERE usuario_id = ? ORDER BY fecha_reclamo DESC");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $consultas = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $consultas;
    }

    public function updateUsuarioNombre($user_id, $nombre) {
        $sql = "UPDATE tbusuario SET nombre = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("si", $nombre, $user_id);
        return $stmt->execute();
    }

    // Obtener datos de usuarios
    public function getUsuariosData() {
        $sql = "SELECT DATE_FORMAT(fechaNacimiento, '%Y-%m-%d') as fecha, COUNT(*) as cantidad 
                FROM tbusuario 
                GROUP BY fecha 
                ORDER BY cantidad DESC";
        $result = $this->con->query($sql);
    
        if (!$result) {
            die("Query failed: " . $this->con->error); 
        }
    
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        return $usuarios;
    }
    
    public function getReservas(){
        $sql = "SELECT DATE_FORMAT(fecha_reserva, '%Y-%m-%d') as fecha, COUNT(*) as cantidad 
        FROM reservas 
        GROUP BY fecha 
        ORDER BY cantidad DESC";
        $result = $this->con->query($sql);

        if (!$result) {
            die("Query failed: " . $this->con->error);
}

$reservas = [];
while ($row = $result->fetch_assoc()) {
    $reservas[] = $row;
}
return $reservas;
    }

    // Obtener datos de reclamos: reclamos por tipo
    public function getReclamosData() {
        $sql = "SELECT asunto as tipo, COUNT(*) as cantidad 
                FROM tbreclamos 
                GROUP BY tipo 
                ORDER BY cantidad DESC";
        $result = $this->con->query($sql);
        if (!$result) {
            die("Query failed: " . $this->con->error);
        }
    
        $reclamos = [];
        while ($row = $result->fetch_assoc()) {
            $reclamos[] = $row;
        }

        return $reclamos;
    }


    public function getdistribucionData() {
        $sql = "SELECT 
                    genero, 
                    COUNT(*) as cantidad
                FROM tbusuario
                GROUP BY genero
                ORDER BY cantidad DESC";
        
        $result = $this->con->query($sql);
        if (!$result) {
            die("Query failed: " . $this->con->error);
        }
        
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        
        return $usuarios;
    }
    

    public function insertarReserva($usuario_id, $numeroMesa, $cantidadPersonas, $descripcion) {
        $sql = "INSERT INTO reservas (usuario_id, numero_mesa, cantidad_personas, descripcion, fecha_reserva, estado) 
                VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, 'Pendiente')";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("iiis", $usuario_id, $numeroMesa, $cantidadPersonas, $descripcion);
        return $stmt->execute();
    }

    public function Mostrar_Reservas() {
        $sql = "SELECT 
            r.id, 
            r.numero_mesa, 
            r.cantidad_personas, 
            r.descripcion, 
            r.estado,
            r.fecha_reserva,
            u.correo,
            u.nombre
            FROM reservas r 
            JOIN tbusuario u ON r.usuario_id = u.id 
            ORDER BY r.estado ASC";
        $resultado = $this->con->query($sql);
        $reservas = array();
        while ($row = $resultado->fetch_assoc()) {
            $reservas[] = $row;
        }
        return $reservas;
    }

    
    
    public function actualizarEstadoReserva($id, $estado) {
        $sql = "UPDATE reservas SET estado = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        
        if ($stmt === false) {
            die("Error en la preparación de la consulta: " . $this->con->error);
        }
        
        $stmt->bind_param("si", $estado, $id);
        $success = $stmt->execute();
        $stmt->close();
        
        return $success;
    }

    public function verificarSiExiste($idUsuario) {
        $sql = "SELECT * FROM reservas WHERE usuario_id = ? AND (estado = 'Pendiente' OR estado = 'En proceso')";
        $stmt = $this->con->prepare($sql);
    
        if ($stmt === false) {
            return ['error' => true, 'message' => $this->con->error];
        }
    
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
    
        $tieneReservas = $resultado->num_rows > 0;
        $stmt->close();
    
        return ['error' => false, 'tieneReservas' => $tieneReservas];
    }
    
    public function Desactivar_Usuario($id) {
        $sql = "UPDATE tbusuario SET verificado = 0 WHERE id = $id";
        $this->con->query($sql);
    }

    public function Activar_Usuario($id) {
        $sql = "UPDATE tbusuario SET verificado = 1 WHERE id = $id";
        $this->con->query($sql);
    }

}

?>

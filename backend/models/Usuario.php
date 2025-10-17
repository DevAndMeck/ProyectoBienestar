<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $username;
    public $password;
    public $nombre_completo;
    public $email;
    public $rol_id;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener usuario por username
    public function obtenerPorUsername() {
        $query = "SELECT u.id, u.username, u.password, u.nombre_completo, u.email, 
                         u.rol_id, u.activo, r.nombre as rol_nombre
                  FROM " . $this->table_name . " u
                  LEFT JOIN roles r ON u.rol_id = r.id
                  WHERE u.username = :username AND u.activo = 1
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $this->username);
        $stmt->execute();

        return $stmt;
    }

    // Obtener permisos del usuario
    public function obtenerPermisos() {
        $query = "SELECT p.nombre
                  FROM permisos p
                  INNER JOIN rol_permisos rp ON p.id = rp.permiso_id
                  INNER JOIN usuarios u ON u.rol_id = rp.rol_id
                  WHERE u.id = :usuario_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":usuario_id", $this->id);
        $stmt->execute();

        $permisos = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permisos[] = $row['nombre'];
        }

        return $permisos;
    }

    // Verificar si el usuario tiene un permiso específico
    public function tienePermiso($permiso) {
        $permisos = $this->obtenerPermisos();
        return in_array($permiso, $permisos);
    }

    // Obtener todos los usuarios
    public function obtenerTodos() {
        $query = "SELECT u.id, u.username, u.nombre_completo, u.email, 
                         u.rol_id, u.activo, r.nombre as rol_nombre, u.created_at
                  FROM " . $this->table_name . " u
                  LEFT JOIN roles r ON u.rol_id = r.id
                  ORDER BY u.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Crear usuario
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET username=:username, password=:password, nombre_completo=:nombre_completo,
                      email=:email, rol_id=:rol_id";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":nombre_completo", $this->nombre_completo);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":rol_id", $this->rol_id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Actualizar usuario
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . "
                  SET nombre_completo=:nombre_completo, email=:email, rol_id=:rol_id
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(":nombre_completo", $this->nombre_completo);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":rol_id", $this->rol_id);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar usuario
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>

<?php
class Registro {
    private $conn;
    private $table_name = "registros";

    public $id;
    public $titulo;
    public $descripcion;
    public $usuario_id;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los registros
    public function obtenerTodos() {
        $query = "SELECT r.id, r.titulo, r.descripcion, r.usuario_id, 
                         r.created_at, r.updated_at, u.nombre_completo as creador
                  FROM " . $this->table_name . " r
                  LEFT JOIN usuarios u ON r.usuario_id = u.id
                  ORDER BY r.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Obtener un registro por ID
    public function obtenerPorId() {
        $query = "SELECT r.id, r.titulo, r.descripcion, r.usuario_id, 
                         r.created_at, r.updated_at, u.nombre_completo as creador
                  FROM " . $this->table_name . " r
                  LEFT JOIN usuarios u ON r.usuario_id = u.id
                  WHERE r.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        return $stmt;
    }

    // Crear registro
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . "
                  SET titulo=:titulo, descripcion=:descripcion, usuario_id=:usuario_id";

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":usuario_id", $this->usuario_id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Actualizar registro
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . "
                  SET titulo=:titulo, descripcion=:descripcion
                  WHERE id=:id";

        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":descripcion", $this->descripcion);
        $stmt->bindParam(":id", $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Eliminar registro
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

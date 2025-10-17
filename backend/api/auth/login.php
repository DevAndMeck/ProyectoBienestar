<?php
include_once '../../config/cors.php';
include_once '../../config/database.php';
include_once '../../models/Usuario.php';
include_once '../../utils/Auth.php';

error_log("[v0] Login attempt started");

$database = new Database();
$db = $database->getConnection();

if ($db === null) {
    error_log("[v0] Database connection failed");
    http_response_code(500);
    echo json_encode(array("mensaje" => "Error de conexión a la base de datos"));
    exit();
}

$usuario = new Usuario($db);

// Obtener datos del POST
$data = json_decode(file_get_contents("php://input"));

error_log("[v0] Received username: " . ($data->username ?? 'none'));

if (!empty($data->username) && !empty($data->password)) {
    $usuario->username = $data->username;
    
    $stmt = $usuario->obtenerPorUsername();
    $num = $stmt->rowCount();

    error_log("[v0] Users found: " . $num);

    if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("[v0] Verifying password for user: " . $row['username']);

        if (password_verify($data->password, $row['password'])) {
            error_log("[v0] Password verified successfully");
            
            $usuario->id = $row['id'];
            $permisos = $usuario->obtenerPermisos();

            $token = Auth::generarToken(
                $row['id'],
                $row['username'],
                $row['rol_id'],
                $row['rol_nombre'],
                $permisos
            );

            http_response_code(200);
            echo json_encode(array(
                "mensaje" => "Login exitoso",
                "token" => $token,
                "usuario" => array(
                    "id" => $row['id'],
                    "username" => $row['username'],
                    "nombre_completo" => $row['nombre_completo'],
                    "email" => $row['email'],
                    "rol_id" => $row['rol_id'],
                    "rol_nombre" => $row['rol_nombre'],
                    "permisos" => $permisos
                )
            ));
        } else {
            error_log("[v0] Password verification failed");
            http_response_code(401);
            echo json_encode(array("mensaje" => "Credenciales incorrectas"));
        }
    } else {
        error_log("[v0] User not found in database");
        http_response_code(401);
        echo json_encode(array("mensaje" => "Usuario no encontrado"));
    }
} else {
    error_log("[v0] Incomplete data received");
    http_response_code(400);
    echo json_encode(array("mensaje" => "Datos incompletos"));
}
?>

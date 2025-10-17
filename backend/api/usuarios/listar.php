<?php
include_once '../../config/cors.php';
include_once '../../config/database.php';
include_once '../../models/Usuario.php';
include_once '../../utils/Auth.php';

// Solo administradores pueden listar usuarios
$usuario_actual = Auth::verificarPermiso('eliminar');

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);
$stmt = $usuario->obtenerTodos();
$num = $stmt->rowCount();

if ($num > 0) {
    $usuarios_arr = array();
    $usuarios_arr["usuarios"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $usuario_item = array(
            "id" => $id,
            "username" => $username,
            "nombre_completo" => $nombre_completo,
            "email" => $email,
            "rol_id" => $rol_id,
            "rol_nombre" => $rol_nombre,
            "activo" => $activo,
            "created_at" => $created_at
        );

        array_push($usuarios_arr["usuarios"], $usuario_item);
    }

    http_response_code(200);
    echo json_encode($usuarios_arr);
} else {
    http_response_code(200);
    echo json_encode(array("usuarios" => array()));
}
?>

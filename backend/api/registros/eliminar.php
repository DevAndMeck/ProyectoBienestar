<?php
include_once '../../config/cors.php';
include_once '../../config/database.php';
include_once '../../models/Registro.php';
include_once '../../utils/Auth.php';

// Verificar que el usuario tenga permiso de eliminar
$usuario = Auth::verificarPermiso('eliminar');

$database = new Database();
$db = $database->getConnection();

$registro = new Registro($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id)) {
    $registro->id = $data->id;

    if ($registro->eliminar()) {
        http_response_code(200);
        echo json_encode(array("mensaje" => "Registro eliminado exitosamente"));
    } else {
        http_response_code(503);
        echo json_encode(array("mensaje" => "No se pudo eliminar el registro"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensaje" => "ID no proporcionado"));
}
?>

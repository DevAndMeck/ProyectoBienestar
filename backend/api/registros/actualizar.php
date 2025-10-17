<?php
include_once '../../config/cors.php';
include_once '../../config/database.php';
include_once '../../models/Registro.php';
include_once '../../utils/Auth.php';

// Verificar que el usuario tenga permiso de actualizar
$usuario = Auth::verificarPermiso('actualizar');

$database = new Database();
$db = $database->getConnection();

$registro = new Registro($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->titulo) && !empty($data->descripcion)) {
    $registro->id = $data->id;
    $registro->titulo = $data->titulo;
    $registro->descripcion = $data->descripcion;

    if ($registro->actualizar()) {
        http_response_code(200);
        echo json_encode(array("mensaje" => "Registro actualizado exitosamente"));
    } else {
        http_response_code(503);
        echo json_encode(array("mensaje" => "No se pudo actualizar el registro"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensaje" => "Datos incompletos"));
}
?>

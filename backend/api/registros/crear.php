<?php
include_once '../../config/cors.php';
include_once '../../config/database.php';
include_once '../../models/Registro.php';
include_once '../../utils/Auth.php';

// Verificar que el usuario tenga permiso de crear
$usuario = Auth::verificarPermiso('crear');

$database = new Database();
$db = $database->getConnection();

$registro = new Registro($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->titulo) && !empty($data->descripcion)) {
    $registro->titulo = $data->titulo;
    $registro->descripcion = $data->descripcion;
    $registro->usuario_id = $usuario->id;

    if ($registro->crear()) {
        http_response_code(201);
        echo json_encode(array("mensaje" => "Registro creado exitosamente"));
    } else {
        http_response_code(503);
        echo json_encode(array("mensaje" => "No se pudo crear el registro"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("mensaje" => "Datos incompletos"));
}
?>

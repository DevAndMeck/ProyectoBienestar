<?php
include_once '../../config/cors.php';
include_once '../../utils/Auth.php';

$usuario = Auth::obtenerUsuarioActual();

if ($usuario) {
    http_response_code(200);
    echo json_encode(array(
        "valido" => true,
        "usuario" => $usuario
    ));
} else {
    http_response_code(401);
    echo json_encode(array(
        "valido" => false,
        "mensaje" => "Token inválido"
    ));
}
?>

<?php
include_once '../../config/cors.php';
include_once '../../config/database.php';
include_once '../../models/Registro.php';
include_once '../../utils/Auth.php';

// Verificar que el usuario tenga permiso de lectura
$usuario = Auth::verificarPermiso('leer');

$database = new Database();
$db = $database->getConnection();

$registro = new Registro($db);
$stmt = $registro->obtenerTodos();
$num = $stmt->rowCount();

if ($num > 0) {
    $registros_arr = array();
    $registros_arr["registros"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $registro_item = array(
            "id" => $id,
            "titulo" => $titulo,
            "descripcion" => $descripcion,
            "usuario_id" => $usuario_id,
            "creador" => $creador,
            "created_at" => $created_at,
            "updated_at" => $updated_at
        );

        array_push($registros_arr["registros"], $registro_item);
    }

    http_response_code(200);
    echo json_encode($registros_arr);
} else {
    http_response_code(200);
    echo json_encode(array("registros" => array()));
}
?>

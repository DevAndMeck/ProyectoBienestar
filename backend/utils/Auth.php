<?php
require_once __DIR__ . '/../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class Auth {
    private static $secret_key = "tu_clave_secreta_super_segura_2024";
    private static $issuer = "http://localhost";
    private static $audience = "http://localhost:4200";
    private static $expiration_time = 86400; // 24 horas

    // Generar JWT
    public static function generarToken($usuario_id, $username, $rol_id, $rol_nombre, $permisos) {
        $issued_at = time();
        $expiration = $issued_at + self::$expiration_time;

        $payload = array(
            "iss" => self::$issuer,
            "aud" => self::$audience,
            "iat" => $issued_at,
            "exp" => $expiration,
            "data" => array(
                "id" => $usuario_id,
                "username" => $username,
                "rol_id" => $rol_id,
                "rol_nombre" => $rol_nombre,
                "permisos" => $permisos
            )
        );

        return JWT::encode($payload, self::$secret_key, 'HS256');
    }

    // Validar JWT
    public static function validarToken() {
        $headers = getallheaders();
        
        if (!isset($headers['Authorization'])) {
            return null;
        }

        $authHeader = $headers['Authorization'];
        $arr = explode(" ", $authHeader);

        if (count($arr) !== 2 || $arr[0] !== 'Bearer') {
            return null;
        }

        $jwt = $arr[1];

        try {
            $decoded = JWT::decode($jwt, new Key(self::$secret_key, 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }

    // Verificar permiso
    public static function verificarPermiso($permiso_requerido) {
        $usuario = self::validarToken();

        if (!$usuario) {
            http_response_code(401);
            echo json_encode(array("mensaje" => "No autorizado. Token inválido o ausente."));
            exit();
        }

        if (!in_array($permiso_requerido, $usuario->permisos)) {
            http_response_code(403);
            echo json_encode(array("mensaje" => "Acceso denegado. No tiene permisos suficientes."));
            exit();
        }

        return $usuario;
    }

    // Obtener usuario actual
    public static function obtenerUsuarioActual() {
        $usuario = self::validarToken();

        if (!$usuario) {
            http_response_code(401);
            echo json_encode(array("mensaje" => "No autorizado. Token inválido o ausente."));
            exit();
        }

        return $usuario;
    }
}
?>

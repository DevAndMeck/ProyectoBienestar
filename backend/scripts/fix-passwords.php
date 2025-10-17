<?php
/**
 * Script para actualizar las contraseñas de los usuarios con hashes correctos
 * Ejecutar: php scripts/fix-passwords.php
 */

require_once __DIR__ . '/../config/database.php';

echo "[v0] Iniciando actualización de contraseñas...\n";

try {
    $database = new Database();
    $conn = $database->getConnection();
    
    if (!$conn) {
        die("Error: No se pudo conectar a la base de datos\n");
    }
    
    echo "[v0] Conexión a base de datos exitosa\n";
    
    // Generar hash para admin123
    $adminPassword = 'admin123';
    $adminHash = password_hash($adminPassword, PASSWORD_BCRYPT);
    echo "[v0] Hash generado para admin: $adminHash\n";
    
    // Generar hash para user123
    $userPassword = 'user123';
    $userHash = password_hash($userPassword, PASSWORD_BCRYPT);
    echo "[v0] Hash generado para usuario1: $userHash\n";
    
    // Actualizar contraseña del admin
    $query = "UPDATE usuarios SET password = :password WHERE username = 'admin'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':password', $adminHash);
    
    if ($stmt->execute()) {
        echo "[v0] ✓ Contraseña de 'admin' actualizada correctamente\n";
    } else {
        echo "[v0] ✗ Error al actualizar contraseña de 'admin'\n";
    }
    
    // Actualizar contraseña del usuario1
    $query = "UPDATE usuarios SET password = :password WHERE username = 'usuario1'";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':password', $userHash);
    
    if ($stmt->execute()) {
        echo "[v0] ✓ Contraseña de 'usuario1' actualizada correctamente\n";
    } else {
        echo "[v0] ✗ Error al actualizar contraseña de 'usuario1'\n";
    }
    
    echo "\n[v0] Proceso completado!\n";
    echo "[v0] Credenciales actualizadas:\n";
    echo "  - Usuario: admin | Contraseña: admin123\n";
    echo "  - Usuario: usuario1 | Contraseña: user123\n";
    
} catch (Exception $e) {
    echo "[v0] Error: " . $e->getMessage() . "\n";
}
?>

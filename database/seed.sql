-- Seed data para el sistema de roles y permisos
USE roles_permisos_system;

-- Insertar roles
INSERT INTO roles (nombre, descripcion) VALUES
('Administrador', 'Acceso completo al sistema con todos los permisos'),
('Usuario', 'Acceso limitado solo para lectura y creación');

-- Insertar permisos
INSERT INTO permisos (nombre, descripcion) VALUES
('crear', 'Permiso para crear nuevos registros'),
('leer', 'Permiso para ver registros'),
('actualizar', 'Permiso para editar registros existentes'),
('eliminar', 'Permiso para borrar registros');

-- Asignar todos los permisos al Administrador
INSERT INTO rol_permisos (rol_id, permiso_id) VALUES
(1, 1), -- Administrador: crear
(1, 2), -- Administrador: leer
(1, 3), -- Administrador: actualizar
(1, 4); -- Administrador: eliminar

-- Asignar permisos limitados al Usuario
INSERT INTO rol_permisos (rol_id, permiso_id) VALUES
(2, 1), -- Usuario: crear
(2, 2); -- Usuario: leer

-- Crear usuarios de ejemplo
-- Password: admin123 (hash bcrypt)
INSERT INTO usuarios (username, password, nombre_completo, email, rol_id) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador del Sistema', 'admin@sistema.com', 1);

-- Password: user123 (hash bcrypt)
INSERT INTO usuarios (username, password, nombre_completo, email, rol_id) VALUES
('usuario1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Usuario de Prueba', 'usuario@sistema.com', 2);

-- Insertar algunos registros de ejemplo
INSERT INTO registros (titulo, descripcion, usuario_id) VALUES
('Primer Registro', 'Este es un registro creado por el administrador', 1),
('Segundo Registro', 'Este es un registro creado por un usuario', 2),
('Tercer Registro', 'Otro registro de ejemplo', 1);

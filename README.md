# Sistema de Roles y Permisos

Sistema completo de gestión de roles y permisos desarrollado con MySQL, PHP y Angular.

## 🚀 Instalación Rápida

### Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

- **XAMPP** (incluye PHP y MySQL) - [Descargar aquí](https://www.apachefriends.org/)
- **Node.js 18+** - [Descargar aquí](https://nodejs.org/)
- **Composer** - [Descargar aquí](https://getcomposer.org/)
- **Angular CLI** - Instalar con: `npm install -g @angular/cli`

## 📦 Instalación Paso a Paso

### 1. Descargar el Proyecto

\`\`\`bash
# Descarga el proyecto y colócalo en:
C:\xampp\htdocs\
\`\`\`

Tu estructura debe quedar así:
\`\`\`
C:\xampp\htdocs\
├── backend/
├── frontend/
└── database/
\`\`\`

### 2. Configurar la Base de Datos

#### Paso 2.1: Iniciar MySQL en XAMPP

1. Abre el **Panel de Control de XAMPP**
2. Haz clic en **Start** en MySQL
3. Verifica que esté corriendo (debe aparecer en verde)

#### Paso 2.2: Crear la Base de Datos

**Opción A: Usando phpMyAdmin (Recomendado)**

1. Abre tu navegador y ve a: `http://localhost/phpmyadmin`
2. Haz clic en **"Nueva"** en el panel izquierdo
3. Nombre de la base de datos: `roles_permisos_system`
4. Cotejamiento: `utf8mb4_general_ci`
5. Haz clic en **"Crear"**
6. Ve a la pestaña **"SQL"**
7. Copia y pega el contenido de `database/schema.sql`
8. Haz clic en **"Continuar"**
9. Repite los pasos 6-8 con `database/seed.sql`

**Opción B: Usando Línea de Comandos**

\`\`\`bash
# Si tu MySQL usa el puerto por defecto (3306):
C:\xampp\mysql\bin\mysql -u root -p < database\schema.sql
C:\xampp\mysql\bin\mysql -u root -p < database\seed.sql

# Si tu MySQL usa el puerto 3307:
C:\xampp\mysql\bin\mysql -u root --port=3307 < database\schema.sql
C:\xampp\mysql\bin\mysql -u root --port=3307 < database\seed.sql
\`\`\`

### 3. Configurar el Backend (PHP)

#### Paso 3.1: Instalar Dependencias

\`\`\`bash
# Navega a la carpeta backend
cd C:\xampp\htdocs\backend

# Instala las dependencias de PHP
composer install
\`\`\`

#### Paso 3.2: Configurar la Conexión a la Base de Datos

Abre el archivo `backend/config/database.php` y verifica/ajusta estos valores:

\`\`\`php
private $host = "localhost";
private $port = "3306";  // Cambia a 3307 si tu MySQL usa ese puerto
private $db_name = "roles_permisos_system";
private $username = "root";
private $password = "";  // Deja vacío si no tienes contraseña
\`\`\`

#### Paso 3.3: Corregir las Contraseñas (Importante)

\`\`\`bash
# Ejecuta este script para generar los hashes correctos de contraseña
php scripts/fix-passwords.php
\`\`\`

Deberías ver:
\`\`\`
Contraseñas actualizadas correctamente
Admin: admin / admin123
Usuario: usuario1 / user123
\`\`\`

#### Paso 3.4: Iniciar el Servidor Backend

\`\`\`bash
# Desde la carpeta backend
php -S localhost:8000
\`\`\`

Deberías ver:
\`\`\`
PHP 8.2.12 Development Server (http://localhost:8000) started
\`\`\`

**¡Deja esta terminal abierta!** El servidor debe estar corriendo.

### 4. Configurar el Frontend (Angular)

#### Paso 4.1: Instalar Dependencias

Abre una **nueva terminal** (deja la del backend corriendo) y ejecuta:

\`\`\`bash
# Navega a la carpeta frontend
cd C:\xampp\htdocs\frontend

# Instala las dependencias de Node.js
npm install
\`\`\`

Esto puede tardar unos minutos.

#### Paso 4.2: Iniciar el Servidor Frontend

\`\`\`bash
# Desde la carpeta frontend
npm start
\`\`\`

O también puedes usar:
\`\`\`bash
ng serve
\`\`\`

Deberías ver:
\`\`\`
** Angular Live Development Server is listening on localhost:4200 **
\`\`\`


## 🎉 ¡Listo! Accede a la Aplicación

Abre tu navegador y ve a:

**Frontend:** http://localhost:4200

## 👥 Usuarios de Prueba

Usa estas credenciales para probar el sistema:

| Usuario | Contraseña | Rol | Permisos |
|---------|-----------|-----|----------|
| `admin` | `admin123` | Administrador | Crear, Leer, Actualizar, Eliminar |
| `usuario1` | `user123` | Usuario | Crear, Leer |

## 🔧 Solución de Problemas

### Error: "vendor/autoload.php not found"

**Solución:**
\`\`\`bash
cd backend
composer install
\`\`\`

### Error: "Call to a member function prepare() on null"

**Causa:** No se puede conectar a la base de datos.

**Solución:**
1. Verifica que MySQL esté corriendo en XAMPP
2. Verifica el puerto en `backend/config/database.php` (3306 o 3307)
3. Verifica que la base de datos `roles_permisos_system` exista

### Error: "Password verification failed"

**Solución:**
\`\`\`bash
cd backend
php scripts/fix-passwords.php
\`\`\`

### Error: "Port 4200 is already in use"

**Solución:**
\`\`\`bash
# Usa otro puerto
ng serve --port 4300
\`\`\`

### El frontend no se conecta al backend

**Solución:**
1. Verifica que el backend esté corriendo en `http://localhost:8000`
2. Revisa la consola del navegador (F12) para ver errores
3. Verifica que las URLs en los servicios Angular apunten a `http://localhost:8000/api`


## 🔐 Características de Seguridad

- ✅ Autenticación JWT con tokens seguros
- ✅ Verificación de permisos en backend y frontend
- ✅ Guards de ruta para proteger páginas
- ✅ Directivas para ocultar elementos según permisos
- ✅ Prepared statements (prevención SQL injection)
- ✅ Password hashing con bcrypt
- ✅ CORS configurado correctamente

## 📚 Características Principales

### Roles y Permisos

**Administrador:**
- ✅ Crear registros
- ✅ Leer registros
- ✅ Actualizar registros
- ✅ Eliminar registros
- ✅ Gestionar usuarios

**Usuario:**
- ✅ Crear registros
- ✅ Leer registros
- ❌ Actualizar registros
- ❌ Eliminar registros
- ❌ Gestionar usuarios

### API Endpoints

**Autenticación:**
- `POST /api/auth/login.php` - Iniciar sesión
- `GET /api/auth/verificar.php` - Verificar token

**Registros (CRUD):**
- `GET /api/registros/listar.php` - Listar registros
- `POST /api/registros/crear.php` - Crear registro
- `PUT /api/registros/actualizar.php` - Actualizar registro
- `DELETE /api/registros/eliminar.php` - Eliminar registro

**Usuarios:**
- `GET /api/usuarios/listar.php` - Listar usuarios (solo admin)

## 🛠️ Tecnologías Utilizadas

**Backend:**
- PHP 8.2
- MySQL 8.0
- Composer
- Firebase JWT Library

**Frontend:**
- Angular 17
- TypeScript
- RxJS
- Tailwind CSS (inline)
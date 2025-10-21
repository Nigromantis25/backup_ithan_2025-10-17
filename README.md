# Proyecto IC Norte (backup_ithan_2025-10-17)

Este repositorio contiene una aplicación PHP simple con varias páginas y un carrito de compras.

Requisitos locales
- XAMPP (Apache + PHP + MySQL)
- PHP 7.4+ (preferible 8.x)
- MySQL

Estructura
- Archivos PHP en la raíz: `index.php`, `registro.php`, `login_rol.php`, `admin_register.php`, etc.
- Carpeta `FINALWEBII/` con frontend y scripts JS

Pasos para preparar y ejecutar localmente (PowerShell en Windows)
1) Abrir PowerShell como administrador y arrancar XAMPP (o usar el panel de control de XAMPP).

2) Copiar los archivos a la carpeta de Apache (ya están en `c:\xampp\htdocs\backup_ithan_2025-10-17`).

3) Crear la base de datos y las tablas (ejemplo):

```sql
CREATE DATABASE icnorte;
USE icnorte;

CREATE TABLE admin (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE empleado (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);

CREATE TABLE usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  carnet VARCHAR(50),
  usuario VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL
);
```

4) Editar `coneccion.php` con tus credenciales MySQL.

5) Navegar en el navegador a: `http://localhost/backup_ithan_2025-10-17/`.

Inicializar Git y subir a remoto (PowerShell)

```powershell
cd c:\xampp\htdocs\backup_ithan_2025-10-17
git init
git add .
git commit -m "Initial commit: proyecto IC Norte backup"
# Crear el repo remoto en GitHub y reemplazar <REMOTE_URL>
git remote add origin <REMOTE_URL>
git branch -M main
git push -u origin main
```

Notas
- Vercel no soporta PHP nativamente; usa un hosting que soporte PHP (Render, Heroku buildpack PHP, un VPS o un hosting compartido con Apache/PHP).
- Si quieres, puedo generar un `composer.json` y scripts para mejorar el proyecto, o ayudarte a crear el repo en GitHub mediante instrucciones o guía paso a paso.
# IC

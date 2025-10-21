<?php
session_start();
include 'coneccion.php'; // Archivo de conexión a la base de datos

// Modo debug: activa agregando ?debug=1 a la URL (solo en local)
$debug = isset($_GET['debug']) && $_GET['debug'] == '1';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Capturar y limpiar los datos del formulario
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $tipo = $_POST['tipo']; // Puede ser 'admin', 'vendedor' o 'usuario'

    // Determinar la tabla según el tipo de usuario
    if ($tipo == 'admin') {
        $tabla = 'admin';
    } elseif ($tipo == 'vendedor') {
        $tabla = 'empleado';
    } else {
        // 'usuario'
        $tabla = 'usuario';
    }

    // Preparar la consulta SQL para obtener la contraseña
    $sql = "SELECT id, usuario, password FROM $tabla WHERE usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();
        if ($debug) {
            echo "<div style='position:fixed;left:8px;top:8px;background:#111;color:#fff;padding:10px;border-radius:6px;z-index:9999;'>";
            echo "DEBUG: tabla=" . htmlspecialchars($tabla) . "<br>usuario=" . htmlspecialchars($usuario) . "<br>num_rows=" . $stmt->num_rows;
            if ($stmt->error) echo "<br>stmt_error=" . htmlspecialchars($stmt->error);
            echo "</div>";
        }

        // Verificar si el usuario existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $usuario_db, $password_db);
            $stmt->fetch();

            // Validar la contraseña
            $password_ok = false;
            if ($tabla === 'usuario') {
                // En la tabla 'usuario' se usan hashes (registro.php usa password_hash)
                if (password_verify($password, $password_db)) {
                    $password_ok = true;
                }
            } else {
                // Para admin/empleado se comparaba directamente (si tus contraseñas están sin hash)
                if ($password === $password_db) {
                    $password_ok = true;
                }
            }

            if ($password_ok) {
                // Iniciar sesión
                $_SESSION['id'] = $id;
                $_SESSION['usuario'] = $usuario_db;
                $_SESSION['tipo'] = $tipo;
                // Registrar evento de login en la tabla login_history (crear si no existe)
                $ip = $_SERVER['REMOTE_ADDR'] ?? '';
                $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
                $createTableSql = "CREATE TABLE IF NOT EXISTS login_history (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    usuario VARCHAR(255),
                    tipo VARCHAR(50),
                    ip VARCHAR(45),
                    user_agent TEXT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
                @$conn->query($createTableSql);

                $logSql = "INSERT INTO login_history (usuario, tipo, ip, user_agent) VALUES (?, ?, ?, ?)";
                if ($logStmt = $conn->prepare($logSql)) {
                    $logStmt->bind_param('ssss', $usuario_db, $tipo, $ip, $user_agent);
                    $logStmt->execute();
                    $logStmt->close();
                }

                // Redirigir al host de XAMPP
                header("Location: /backup_ithan_2025-10-17/FINALWEBII/index.html");
                exit();
            } else {
                echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error en la consulta'); window.history.back();</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin/Vendedor</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Roboto', sans-serif;
        }

        .login-container {
            background: #ffffff;
            width: 100%;
            max-width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        }

        .login-container h2 {
            text-align: center;
            color: #495057;
            margin-bottom: 30px;
            font-size: 24px;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ced4da;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus, select:focus {
            border-color: #007bff;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            margin-top: 12px;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .login-container .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Acceso Admin/Vendedor</h2>
        <form action="" method="POST">
                <input type="text" name="usuario" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <select name="tipo" required>
                    <option value="admin">Administrador</option>
                    <option value="vendedor">Vendedor</option>
                    <option value="usuario">Usuario</option>
                </select>
                <button type="submit" class="btn">Ingresar</button>
            </form>

        <div class="footer">
            <button class="btn btn-secondary" onclick="window.location.href='/backup_ithan_2025-10-17/FINALWEBII/index.html'">Regresar a Inicio</button>
        </div>
    </div>

</body>
</html>

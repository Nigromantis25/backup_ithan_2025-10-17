<?php
include 'coneccion.php';

$success = null;
$errors = [];

// Función para generar una contraseña segura
function generateSecurePassword($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, strlen($chars) - 1)];
    }
    return $password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create_admin':
                $usuario = trim($_POST['usuario']);
                $password = $_POST['password'];
                
                if (empty($usuario) || empty($password)) {
                    $errors[] = 'Usuario y contraseña son requeridos';
                } else {
                    $sql = "INSERT INTO admin (usuario, password) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $usuario, $password);
                    
                    if ($stmt->execute()) {
                        $success = "Administrador creado exitosamente. Usuario: $usuario";
                    } else {
                        $errors[] = "Error al crear administrador: " . $stmt->error;
                    }
                    $stmt->close();
                }
                break;

            case 'create_vendedor':
                $usuario = trim($_POST['usuario']);
                $password = $_POST['password'];
                
                if (empty($usuario) || empty($password)) {
                    $errors[] = 'Usuario y contraseña son requeridos';
                } else {
                    $sql = "INSERT INTO empleado (usuario, password) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ss', $usuario, $password);
                    
                    if ($stmt->execute()) {
                        $success = "Vendedor creado exitosamente. Usuario: $usuario";
                    } else {
                        $errors[] = "Error al crear vendedor: " . $stmt->error;
                    }
                    $stmt->close();
                }
                break;

            case 'create_usuario':
                $usuario = trim($_POST['usuario']);
                $password = $_POST['password'];
                $carnet = trim($_POST['carnet']);
                
                if (empty($usuario) || empty($password) || empty($carnet)) {
                    $errors[] = 'Usuario, contraseña y cédula son requeridos';
                } else {
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);
                    $sql = "INSERT INTO usuario (carnet, usuario, password) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('sss', $carnet, $usuario, $password_hash);
                    
                    if ($stmt->execute()) {
                        $success = "Usuario creado exitosamente. Usuario: $usuario";
                    } else {
                        $errors[] = "Error al crear usuario: " . $stmt->error;
                    }
                    $stmt->close();
                }
                break;
        }
    }
}

// Generar una contraseña segura para sugerir
$suggested_password = generateSecurePassword();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Cuentas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0f0f0f;
            color: #e6e6e6;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .card {
            background: #111;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, button {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #333;
            background: #0b0b0b;
            color: #fff;
        }
        button {
            background: linear-gradient(90deg,#00b4ff,#7b00ff);
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        .success {
            background: #062b1f;
            color: #9ff;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .error {
            background: #3b0b0b;
            color: #ffc;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .nav {
            margin-bottom: 20px;
        }
        .nav a {
            color: #9ee;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="admin_access.php">← Volver al Acceso</a>
        </div>
        
        <?php if (!empty($errors)): ?>
            <?php foreach($errors as $error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <!-- Formulario para Administrador -->
        <div class="card">
            <h2>Crear Nuevo Administrador</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create_admin">
                <div class="form-group">
                    <label>Usuario:</label>
                    <input type="text" name="usuario" required>
                </div>
                <div class="form-group">
                    <label>Contraseña:</label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars($suggested_password); ?>" required>
                </div>
                <button type="submit">Crear Administrador</button>
            </form>
        </div>

        <!-- Formulario para Vendedor -->
        <div class="card">
            <h2>Crear Nuevo Vendedor</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create_vendedor">
                <div class="form-group">
                    <label>Usuario:</label>
                    <input type="text" name="usuario" required>
                </div>
                <div class="form-group">
                    <label>Contraseña:</label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars(generateSecurePassword()); ?>" required>
                </div>
                <button type="submit">Crear Vendedor</button>
            </form>
        </div>

        <!-- Formulario para Usuario -->
        <div class="card">
            <h2>Crear Nuevo Usuario</h2>
            <form method="POST">
                <input type="hidden" name="action" value="create_usuario">
                <div class="form-group">
                    <label>Cédula:</label>
                    <input type="text" name="carnet" required>
                </div>
                <div class="form-group">
                    <label>Usuario:</label>
                    <input type="text" name="usuario" required>
                </div>
                <div class="form-group">
                    <label>Contraseña:</label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars(generateSecurePassword()); ?>" required>
                </div>
                <button type="submit">Crear Usuario</button>
            </form>
        </div>
    </div>
</body>
</html>
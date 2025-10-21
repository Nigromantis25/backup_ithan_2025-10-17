<?php
// create_test_users.php
// Script para crear cuentas de prueba: admin, vendedor (empleado) y usuario.
// Úsalo desde el navegador: http://localhost/ithan/create_test_users.php

include 'coneccion.php';

if (!$conn) {
    die("No se pudo conectar a la base de datos.\n");
}

function exists_user($conn, $tabla, $usuario) {
    $sql = "SELECT 1 FROM $tabla WHERE usuario = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('s', $usuario);
        $stmt->execute();
        $stmt->store_result();
        $found = $stmt->num_rows > 0;
        $stmt->close();
        return $found;
    }
    return false;
}

$created = [];
$errors = [];

// 1) Crear admin (contraseña en texto porque el login actual compara en claro para admin/empleado)
$admin_user = 'admin_test';
$admin_pass = 'admin123';
if (!exists_user($conn, 'admin', $admin_user)) {
    $sql = "INSERT INTO admin (usuario, password) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $admin_user, $admin_pass);
        if ($stmt->execute()) {
            $created[] = "admin: $admin_user";
        } else {
            $errors[] = "admin insert error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $errors[] = "prepare admin insert failed: " . $conn->error;
    }
} else {
    $errors[] = "admin ya existe: $admin_user";
}

// 2) Crear vendedor / empleado
$vendedor_user = 'vendedor_test';
$vendedor_pass = 'vend123';
if (!exists_user($conn, 'empleado', $vendedor_user)) {
    $sql = "INSERT INTO empleado (usuario, password) VALUES (?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('ss', $vendedor_user, $vendedor_pass);
        if ($stmt->execute()) {
            $created[] = "vendedor: $vendedor_user";
        } else {
            $errors[] = "vendedor insert error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $errors[] = "prepare vendedor insert failed: " . $conn->error;
    }
} else {
    $errors[] = "vendedor ya existe: $vendedor_user";
}

// 3) Crear usuario (tabla usuario usa carnet, usuario, password — password debe ser hasheado)
$usuario_user = 'usuario_test';
$usuario_pass_plain = 'user12345';
$carnet = '0001';
if (!exists_user($conn, 'usuario', $usuario_user)) {
    $password_hash = password_hash($usuario_pass_plain, PASSWORD_BCRYPT);
    $sql = "INSERT INTO usuario (carnet, usuario, password) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param('sss', $carnet, $usuario_user, $password_hash);
        if ($stmt->execute()) {
            $created[] = "usuario: $usuario_user";
        } else {
            $errors[] = "usuario insert error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $errors[] = "prepare usuario insert failed: " . $conn->error;
    }
} else {
    $errors[] = "usuario ya existe: $usuario_user";
}

$conn->close();

?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Crear cuentas de prueba</title>
    <style>body{font-family:Arial,Helvetica,sans-serif; padding:24px; background:#f7f7f7;} .box{background:#fff;padding:18px;border-radius:8px; max-width:720px; margin:0 auto; box-shadow:0 6px 18px rgba(0,0,0,0.06);} h1{font-size:20px;} ul{line-height:1.6}</style>
</head>
<body>
<div class="box">
    <h1>Cuentas de prueba - Resultado</h1>
    <?php if (!empty($created)): ?>
        <h3>Creado:</h3>
        <ul>
            <?php foreach ($created as $c): ?>
                <li><?php echo htmlspecialchars($c); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <h3>Mensajes / Errores:</h3>
        <ul>
            <?php foreach ($errors as $e): ?>
                <li><?php echo htmlspecialchars($e); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h3>Credenciales creadas (para probar):</h3>
    <ul>
        <li>Admin: usuario = <strong>admin_test</strong>, password = <strong>admin123</strong></li>
        <li>Vendedor: usuario = <strong>vendedor_test</strong>, password = <strong>vend123</strong></li>
        <li>Usuario: usuario = <strong>usuario_test</strong>, password = <strong>user12345</strong></li>
    </ul>

    <p>Puedes iniciar sesión en <code>http://localhost/ithan/login_rol.php</code> y elegir el rol correspondiente en el select.</p>
</div>
</body>
</html>
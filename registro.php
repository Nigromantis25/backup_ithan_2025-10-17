<?php
include 'coneccion.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar la conexión a la base de datos
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Capturar y limpiar datos del formulario
    $carnet = trim($_POST['carnet']);
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];
    $confirmar_password = $_POST['confirmar_password'];

    // Verificar que las contraseñas coincidan
    if ($password !== $confirmar_password) {
        echo "<script>alert('Las contraseñas no coinciden'); window.history.back();</script>";
        exit();
    }

    // Hashear la contraseña antes de guardarla
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Preparar la consulta SQL para insertar los datos
    $sql = "INSERT INTO usuario (carnet, usuario, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $carnet, $usuario, $password_hash);
        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso'); window.location.href = 'index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error en el registro: " . $stmt->error . "'); window.history.back();</script>";
            exit();
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error en la preparación de la consulta'); window.history.back();</script>";
        exit();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Helvetica Neue', sans-serif;
        }

        .container {
            background-color: #fff;
            width: 350px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(228, 215, 215, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #333;
            font-size: 28px;
        }

        label {
            font-weight: bold;
            text-align: left;
            display: block;
            margin: 12px 0 5px;
            font-size: 16px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            margin-bottom: 18px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            border-color: #5c6bc0;
            box-shadow: 0 0 8px rgba(92, 107, 192, 0.4);
        }

        .btn {
            background-color: #5c6bc0;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .btn:hover {
            background-color: #3f4a8a;
            transform: scale(1.05);
        }

        .link {
            display: block;
            margin-top: 12px;
            color: #5c6bc0;
            text-decoration: none;
            font-size: 14px;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Crear Cuenta</h2>
        <form action="registro.php" method="POST">
            <label>Cédula de Identidad</label>
            <input type="text" name="carnet" placeholder="Tu ID de usuario" required>

            <label>usuario</label>
            <input type="text" name="usuario" placeholder="Tu usuario" required>

            <label>password</label>
            <input type="password" name="password" placeholder="Crear un password" required>

            <label>Confirmar password</label>
            <input type="password" name="confirmar_password" placeholder="Repite tu password" required>

            <button class="btn" type="submit">Registrarse</button>
        </form>

        <a href="index.php" class="link">¿Ya tienes una cuenta? Iniciar Sesión</a>
    </div>
</body>

</html>


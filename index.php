<?php
session_start();
include 'coneccion.php'; // Archivo de conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Capturar y limpiar los datos del formulario
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    // Preparar la consulta SQL para obtener la contraseña hasheada
    $sql = "SELECT id, usuario, password FROM usuario WHERE usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $stmt->store_result();

        // Verificar si el usuario existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $usuario_db, $password_hash);
            $stmt->fetch();

            // Validar la contraseña
            if (password_verify($password, $password_hash)) {
                // Iniciar sesión
                $_SESSION['id'] = $id;
                $_SESSION['usuario'] = $usuario_db;
                header("Location: FINALWEBII/index.html");
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
    <title>Iniciar Sesión</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #e5ece3ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background-color: #292727ff;
            width: 100%;
            max-width: 360px;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 0px 30px 1px rgba(0, 255, 117, 0.30);
            text-align: center;
        }

        h2 {
            text-align: center;
            margin: 2em;
            color: rgb(0, 255, 200);
            font-size: 1.2em;
        }

        .field {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5em;
            border-radius: 25px;
            padding: 0.6em;
            border: none;
            outline: none;
            color: white;
            background-color: #171717;
            box-shadow: inset 2px 5px 10px rgba(224, 216, 216, 1);
        }

        .input-field {
            background: none;
            border: none;
            outline: none;
            width: 100%;
            color: rgb(0, 255, 200);
        }

        .btn {
            display: flex;
            justify-content: center;
            flex-direction: row;
            margin-top: 2.5em;
            padding: 0.5em;
            border-radius: 5px;
            border: none;
            outline: none;
            transition: .4s ease-in-out;
            background-image: linear-gradient(163deg, #00ff75 0%, #3700ff 100%);
            color: rgb(0, 0, 0);
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-image: linear-gradient(163deg, #00642f 0%, #13034b 100%);
            color: rgb(0, 255, 200);
        }

        .link {
            display: block;
            margin-top: 12px;
            color: rgb(0, 255, 200);
            text-decoration: none;
            font-size: 14px;
        }

        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <form action="" method="POST">
            <div class="field">
                <input type="text" name="usuario" class="input-field" placeholder="Usuario" required>
            </div>
            <div class="field">
                <input type="password" name="password" class="input-field" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn">Ingresar</button>
        </form>
        <a href="registro.php" class="link">¿No tienes cuenta? Regístrate</a>
    </div>
</body>

</html>


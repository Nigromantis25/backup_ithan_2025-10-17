<?php
// Historial de usuarios: carga desde la base de datos usando coneccion.php
require_once __DIR__ . '/coneccion.php';

// Si hay error de conexión, mostrar mensaje
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

$sql = "SELECT id, usuario, carnet, password FROM usuario ORDER BY id DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Historial de Usuarios</title>
    <link rel="stylesheet" href="FINALWEBII/style.css">
    <style>
        .historial-container{ max-width:1100px; margin:30px auto; padding:20px; background:#fff; border-radius:8px; box-shadow:0 6px 18px rgba(0,0,0,0.15); }
        table{ width:100%; border-collapse:collapse; }
        th, td{ padding:10px 12px; border-bottom:1px solid #e6e6e6; text-align:left; }
        th{ background:var(--colot-nav); color:white; }
        .small{ font-size:13px; color:#666; }
        .actions{ text-align:right; margin-bottom:12px; }
        .btn { padding:8px 12px; background:#2ecc71; color:#fff; border:none; border-radius:6px; text-decoration:none; }
        .btn-danger { background:#e74c3c; }
    </style>
</head>
<body>
    <div class="historial-container">
        <div class="actions">
            <a href="FINALWEBII/index.html" class="btn">Volver al sitio</a>
        </div>
        <h2>Historial de usuarios</h2>
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Carnet</th>
                        <th>Contraseña (hash)</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['usuario']); ?></td>
                        <td><?php echo htmlspecialchars($row['carnet']); ?></td>
                        <td class="small"><?php echo htmlspecialchars($row['password']); ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No se encontraron registros en la tabla <code>usuario</code>.</p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
// Ejemplo de historial de usuarios
$usuarios = [
    ["id" => 1, "nombre" => "Ithan", "correo" => "ithan@email.com", "fecha" => "2025-10-16"],
    ["id" => 2, "nombre" => "Ana", "correo" => "ana@email.com", "fecha" => "2025-10-15"],
    ["id" => 3, "nombre" => "Luis", "correo" => "luis@email.com", "fecha" => "2025-10-14"],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Usuarios</title>
    <link rel="stylesheet" href="FINALWEBII/style.css">
    <style>
        .historial-container {
            max-width: 700px;
            margin: 40px auto;
            background: #222;
            color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            padding: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: left;
        }
        th {
            background: #2ecc71;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="historial-container">
        <h2>Historial de Usuarios</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha</th>
            </tr>
            <?php foreach($usuarios as $usuario): ?>
            <tr>
                <td><?php echo $usuario["id"]; ?></td>
                <td><?php echo $usuario["nombre"]; ?></td>
                <td><?php echo $usuario["correo"]; ?></td>
                <td><?php echo $usuario["fecha"]; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
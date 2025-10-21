<?php
// admin_access.php - plantilla de acceso mejorada (interfaz oscura)
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Acceso Admin/Vendedor/Usuario</title>
  <style>
  :root{--bg:#ffffff;--card:#ffffff;--accent:#0d9488;--btn-grad:linear-gradient(90deg,#06b6d4,#7c3aed);}    
  body{margin:0;background:var(--bg);font-family:Arial,Helvetica,sans-serif;color:#06202a;display:flex;align-items:center;justify-content:center;height:100vh}
  .card{width:380px;background:linear-gradient(180deg,#ffffff,#f3f4f6);border-radius:16px;padding:36px;box-shadow:0 8px 30px rgba(233, 235, 241, 0.07);border:1px solid rgba(2,6,23,0.04)}
  h1{color:var(--accent);text-align:center;margin:0 0 18px;font-size:22px}
    .field{margin-bottom:12px}
  input[type="text"],input[type="password"],select{width:100%;padding:12px 14px;border-radius:24px;background:#ffffff;border:1px solid rgba(2,6,23,0.06);color:#06202a;outline:none;box-shadow:inset 0 3px 8px rgba(2,6,23,0.03)}
    .actions{display:flex;align-items:center;justify-content:space-between;margin-top:16px}
    .btn{padding:10px 18px;border-radius:10px;border:0;color:#051017;background:var(--btn-grad);cursor:pointer;font-weight:700}
  .link{color:var(--accent);text-decoration:none;font-size:13px}
  .secondary{background:#e6eef3;color:#06202a;padding:10px 14px;border-radius:10px;border:0}
  .help{font-size:13px;color:#475569;display:block;text-align:center;margin-top:10px}
  .smallbtn{display:inline-block;padding:8px 12px;border-radius:8px;background:transparent;border:1px solid rgba(2,6,23,0.06);color:var(--accent);text-decoration:none}
  </style>
</head>
<body>
  <div class="card">
    <h1>Iniciar Sesión</h1>
    <form action="login_rol.php" method="POST">
      <div class="field"><input type="text" name="usuario" placeholder="Usuario" required></div>
      <div class="field"><input type="password" name="password" placeholder="Contraseña" required></div>
      <div class="field"><select name="tipo" required>
        <option value="admin">Administrador</option>
        <option value="vendedor">Vendedor</option>
        <option value="usuario">Usuario</option>
      </select></div>
      <div class="actions">
        <button class="btn" type="submit">Ingresar</button>
        <a class="smallbtn" href="admin_register.php">Registrarse</a>
      </div>
    </form>
    <div class="help">Si necesitas crear un Admin de prueba, usa el botón <strong>Crear Admin Demo</strong> abajo.</div>
    <div style="text-align:center;margin-top:12px">
      <a class="secondary" href="create_demo_admin.php">Crear Admin Demo</a>
      <a class="secondary" style="margin-left:8px" href="user_history.php">Historial de usuarios</a>
    </div>
  </div>
</body>
</html>
<link rel="stylesheet" href="/ithan/chat_widget.css">
<script src="/ithan/chat_widget.js"></script>
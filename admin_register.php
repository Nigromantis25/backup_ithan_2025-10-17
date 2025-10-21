<?php
// admin_register.php - formulario que permite registrar admin, empleado (vendedor) y usuario
include 'coneccion.php';

$errors=[];
$success=null;
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $tipo = $_POST['tipo'];
    $usuario = trim($_POST['usuario']);
    $password = $_POST['password'];

    if ($tipo === 'usuario'){
        $carnet = isset($_POST['carnet'])? trim($_POST['carnet']): '';
        if ($carnet === '') $errors[]='Cédula (carnet) es requerida para usuario.';
    }

    if (empty($errors)){
        if ($tipo === 'admin'){
            $sql = "INSERT INTO admin (usuario,password) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss',$usuario,$password);
            if ($stmt->execute()) $success='Admin registrado.'; else $errors[]=$stmt->error;
            $stmt->close();
        } elseif ($tipo === 'vendedor'){
            $sql = "INSERT INTO empleado (usuario,password) VALUES (?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss',$usuario,$password);
            if ($stmt->execute()) $success='Vendedor registrado.'; else $errors[]=$stmt->error;
            $stmt->close();
        } else {
            // usuario normal -> hashear
            $password_hash = password_hash($password,PASSWORD_BCRYPT);
            $sql = "INSERT INTO usuario (carnet,usuario,password) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss',$carnet,$usuario,$password_hash);
            if ($stmt->execute()) $success='Usuario registrado.'; else $errors[]=$stmt->error;
            $stmt->close();
        }
    }

}

?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><title>Registrar (Admin/Vendedor/Usuario)</title>
<style>body{font-family:Arial;background:#0f0f0f;color:#e6e6e6;display:flex;align-items:center;justify-content:center;height:100vh} .box{background:#111;padding:22px;border-radius:12px;width:420px} label{display:block;margin:8px 0 4px} input,select{width:100%;padding:10px;border-radius:8px;border:1px solid #222;background:#0b0b0b;color:#ddd} .btn{margin-top:12px;padding:10px;border-radius:8px;border:0;background:linear-gradient(90deg,#00b4ff,#7b00ff);color:#051017;font-weight:700} .msg{background:#062b1f;padding:10px;border-radius:8px;color:#9ff;margin-bottom:8px} .err{background:#3b0b0b;padding:10px;border-radius:8px;color:#ffc;margin-bottom:8px}</style>
</head>
<body>
<div class="box">
  <h2>Registrar cuenta</h2>
  <?php if (!empty($errors)): ?><div class="err"><?php foreach($errors as $e) echo htmlspecialchars($e)."<br>";?></div><?php endif; ?>
  <?php if ($success): ?><div class="msg"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
  <form method="POST">
    <label>Tipo</label>
    <select name="tipo" id="tipo" onchange="onTipo()">
      <option value="admin">Administrador</option>
      <option value="vendedor">Vendedor</option>
      <option value="usuario">Usuario</option>
    </select>
    <label>Cédula (solo para Usuario)</label>
    <input type="text" name="carnet" id="carnet">
    <label>Usuario</label>
    <input type="text" name="usuario" required>
    <label>Contraseña</label>
    <input type="password" name="password" required>
    <button class="btn" type="submit">Registrar</button>
  </form>
  <p style="margin-top:10px;color:#9aa">Volver: <a style="color:#9ee" href="admin_access.php">Acceso</a></p>
</div>
<script>
function onTipo(){
  var t=document.getElementById('tipo').value;
  document.getElementById('carnet').style.display = (t==='usuario') ? 'block' : 'none';
}
onTipo();
</script>
</body>
</html>
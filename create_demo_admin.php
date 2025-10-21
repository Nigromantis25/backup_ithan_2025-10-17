<?php
// create_demo_admin.php - crea un admin demo si no existe
include 'coneccion.php';
$created=false;
if (!$conn) die('No DB');
$admin_user='superadmin';
$admin_pass='SuperPass123';
// comprobar existencia
$stmt = $conn->prepare("SELECT id FROM admin WHERE usuario = ? LIMIT 1");
if ($stmt){
    $stmt->bind_param('s',$admin_user);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows==0){
        $stmt->close();
        $ins = $conn->prepare("INSERT INTO admin (usuario,password) VALUES (?,?)");
        if ($ins){
            $ins->bind_param('ss',$admin_user,$admin_pass);
            if ($ins->execute()) $created=true; else $err=$ins->error;
            $ins->close();
        } else $err=$conn->error;
    }
    $stmt->close();
} else $err=$conn->error;
$conn->close();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Crear Admin Demo</title></head><body style="font-family:Arial;padding:18px;background:#f7f7f7">
<div style="max-width:680px;margin:30px auto;background:#fff;padding:20px;border-radius:8px">
<h2>Crear Admin Demo</h2>
<?php if (!empty($err)): ?><div style="color:#900">Error: <?php echo htmlspecialchars($err);?></div><?php endif; ?>
<?php if ($created): ?><div style="color:green">Admin creado: usuario=<?php echo $admin_user;?> password=<?php echo $admin_pass;?></div><?php else: ?><div>El admin ya existe o no se creó. Usuario objetivo: <?php echo $admin_user;?></div><?php endif; ?>
<p>Volver a <a href="admin_access.php">Acceso</a></p>
</div>
</body></html>
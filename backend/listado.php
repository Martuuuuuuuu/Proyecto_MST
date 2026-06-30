<?php
require_once 'conexion.php';
// Consultar todos los alumnos ordenados por fecha descendente
$sql = "SELECT * FROM alumnos ORDER BY fecha_reg DESC";
$stmt = $pdo->query($sql);
$alumnos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de Alumnos</title>
<style>
body { font-family: Arial; max-width: 800px; margin: 40px auto; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th { background: #1B3A6B; color: white; padding: 10px; }
td { padding: 9px; border-bottom: 1px solid #ddd; }
tr:hover { background: #f0f4f8; }
.btn { display:inline-block; padding:10px 20px; background:#1C7293;
color:white; text-decoration:none; border-radius:5px; }
</style>
</head>
<body>
<?php if (isset($_GET['msg']) && $_GET['msg'] === 'ok'): ?>
<p style="color:green; font-weight:bold;">
✔ Alumno registrado correctamente.
</p>
<?php endif; ?>
<h1>Alumnos registrados</h1>
<a class="btn" href="formulario.html">+ Nuevo alumno</a>
<table>
<tr>
<th>ID</th><th>Nombre</th><th>Apellido</th>
<th>Email</th><th>Curso</th><th>Fecha</th>
</tr>
<?php foreach ($alumnos as $alumno): ?>
<tr>
<td><?= $alumno['id'] ?></td>
<td><?= htmlspecialchars($alumno['nombre']) ?></td>
<td><?= htmlspecialchars($alumno['apellido']) ?></td>
<td><?= htmlspecialchars($alumno['email']) ?></td>
<td><?= htmlspecialchars($alumno['curso']) ?></td>
<td><?= $alumno['fecha_reg'] ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
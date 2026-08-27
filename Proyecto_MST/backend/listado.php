<?php
// Incluye la conexión con la base de datos.
require_once 'conexion.php';
// Consulta para obtener todos los usuarios.
// Se ordenan desde el último registrado hasta el primero.
$sql = "SELECT * FROM usuarios ORDER BY id_usuario DESC";
// Ejecuta la consulta.
$stmt = $pdo->query($sql);
// Guarda todos los registros obtenidos.
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Listado de Usuarios</title>
</head>
<body>
<h1>Usuarios registrados</h1>
<!-- Comienza la tabla -->
<table border="1">
<tr>
<!-- Encabezados de la tabla -->
<th>ID</th>
<th>Nombre</th>
<th>Apellido</th>
<th>Gmail</th>
<th>DNI</th>
<th>Teléfono</th>
</tr>
<!-- Recorre todos los usuarios obtenidos de la base de datos -->
<?php foreach($usuarios as $usuario): ?>
<tr>
<!-- Muestra el ID del usuario -->
<td><?= $usuario['id_usuario'] ?></td>
<!-- Muestra el nombre.
htmlspecialchars evita que se ejecute código HTML o JavaScript. -->
<td><?= htmlspecialchars($usuario['nombre']) ?></td>
<!-- Muestra el apellido -->
<td><?= htmlspecialchars($usuario['apellido']) ?></td>
<!-- Muestra el gmail -->
<td><?= htmlspecialchars($usuario['gmail']) ?></td>
<!-- Muestra el DNI -->
<td><?= htmlspecialchars($usuario['DNI']) ?></td>
<!-- Muestra el teléfono -->
<td><?= htmlspecialchars($usuario['telefono']) ?></td>
</tr>
<!-- Finaliza el recorrido del foreach -->
<?php endforeach; ?>
</table>
</body>
</html>
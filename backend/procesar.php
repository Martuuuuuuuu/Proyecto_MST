<?php
// Incluir el archivo de conexión
require_once 'conexion.php';
// Verificar que el formulario fue enviado por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// 1. Leer y limpiar los datos recibidos
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$email = trim($_POST['email']);
$curso = trim($_POST['curso']);
// 2. Validar que no vengan vacíos
if (empty($nombre) || empty($apellido) || empty($email) || empty($curso)) {
die('❌ Todos los campos son obligatorios.');
}
// 3. Validar formato de email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
die('❌ El email no tiene un formato válido.');
}
// 4. Preparar la consulta SQL (con parámetros, NO con concatenación)
$sql = "INSERT INTO alumnos (nombre, apellido, email, curso)
VALUES (:nombre, :apellido, :email, :curso)";
// 5. Preparar el statement
$stmt = $pdo->prepare($sql);
// 6. Ejecutar con los datos reales
$stmt->execute([
':nombre' => $nombre,
':apellido' => $apellido,
':email' => $email,
':curso' => $curso,
]);
// 7. Redirigir al listado con mensaje de éxito
header('Location: listado.php?msg=ok');
exit;
} else {
// Si alguien entra directamente a esta URL, lo redirigimos
header('Location: formulario.html');
exit;
}
?>
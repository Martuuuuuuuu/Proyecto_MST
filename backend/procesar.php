<?php
// Incluye el archivo que realiza la conexión con MySQL.
require_once 'conexion.php';
// Verifica que el formulario haya sido enviado utilizando POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guarda el nombre enviado desde el formulario.
    $nombre = trim($_POST['nombre']);
    // Guarda el apellido.
    $apellido = trim($_POST['apellido']);
    // Guarda el gmail.
    $gmail = trim($_POST['gmail']);
    // Guarda el DNI.
    $dni = trim($_POST['dni']);
    // Guarda el teléfono.
    $telefono = trim($_POST['telefono']);
    // Consulta SQL para insertar un nuevo usuario.
    $sql = "INSERT INTO usuarios
            (nombre, apellido, gmail, DNI, telefono)
            VALUES
            (:nombre, :apellido, :gmail, :dni, :telefono)";
    // Prepara la consulta para mayor seguridad.
    $stmt = $pdo->prepare($sql);
    // Reemplaza los parámetros por los datos ingresados
    // y ejecuta la consulta.
    $stmt->execute([
        ':nombre' => $nombre,
        ':apellido' => $apellido,
        ':gmail' => $gmail,
        ':dni' => $dni,
        ':telefono' => $telefono
    ]);
    // Redirecciona al listado cuando el registro fue exitoso.
    header("Location: listado.php?msg=ok");
    // Finaliza el script.
    exit;
}
?>
<?php
// Dirección del servidor de la base de datos.
// En XAMPP siempre es localhost.
$host = "localhost";
// Usuario de MySQL.
$usuario = "root";
// Contraseña del usuario.
// En XAMPP normalmente está vacía.
$password = "";
// Nombre de la base de datos.
$base = "cooperadora";
try{
    // Crea la conexión con la base de datos utilizando PDO.
    $pdo = new PDO(
        // Indica el servidor, la base de datos y la codificación.
        "mysql:host=$host;dbname=$base;charset=utf8mb4",
        // Usuario de la base de datos.
        $usuario,
        // Contraseña del usuario.
        $password
    );
    // Hace que los errores de la base de datos se muestren como excepciones.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Devuelve los resultados como un arreglo asociativo.
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}catch(PDOException $e){
    // Si ocurre un error de conexión, muestra el mensaje.
    die("Error de conexión: ".$e->getMessage());
}
?>
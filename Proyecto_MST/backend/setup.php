<?php
$host = "127.0.0.1";
$usuario = "root";
$password = "";

try {
    // Conectamos sin especificar la base de datos para poder crearla
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Crear base de datos
    $pdo->exec("CREATE DATABASE IF NOT EXISTS cooperadora2");
    $pdo->exec("USE cooperadora2");
    
    // Crear tabla usuarios
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        mail VARCHAR(100) NOT NULL,
        pass VARCHAR(255) NOT NULL
    )");
    
    // Crear tabla productos
    $pdo->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        imagen VARCHAR(255) NOT NULL,
        descripcion TEXT NOT NULL,
        precio DECIMAL(10, 2) NOT NULL
    )");

    // (Opcional) Insertar un producto de prueba si la tabla está vacía
    $stmt = $pdo->query("SELECT COUNT(*) FROM productos");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO productos (nombre, imagen, descripcion, precio) VALUES 
        ('Alfajor de Maicena', 'https://via.placeholder.com/150', 'Exquisito alfajor casero', 500.00)");
    }
    
    echo "<h1>Base de datos y tablas creadas con éxito.</h1>";
    echo "<a href='index.php'>Ir al inicio</a>";
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
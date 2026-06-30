<?php
// Datos del servidor
$host = 'localhost'; // XAMPP siempre usa localhost
$usuario = 'root'; // Usuario por defecto en XAMPP
$password = ''; // Sin contraseña en XAMPP local
$base = 'colegio'; // Nombre de la base que creamos
try {
// PDO = PHP Data Objects: forma moderna y segura de conectar
$pdo = new PDO(
"mysql:host=$host;dbname=$base;charset=utf8mb4",
$usuario,
$password
);
// Si hay un error, lanzá una excepción (no lo ocultes)
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Devuelve resultados como arrays asociativos (clave => valor)
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
die('❌ Error de conexión: ' . $e->getMessage());
}
?>
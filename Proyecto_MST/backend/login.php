<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mail = trim($_POST['mail']);
    $pass = trim($_POST['pass']);
    
    $sql = "SELECT * FROM usuarios WHERE mail = :mail";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':mail' => $mail]);
    $usuario = $stmt->fetch();
    
    // Verificamos si el usuario existe y si la contraseña coincide
    if ($usuario && password_verify($pass, $usuario['pass'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['username'] = $usuario['username'];
        
        header("Location: listado.php");
        exit;
    } else {
        echo "Email o contraseña incorrectos. <a href='index.php'>Volver</a>";
    }
}
?>
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $imagen = trim($_POST['imagen']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    
    if($nombre && $imagen && $descripcion && $precio > 0) {
        $sql = "INSERT INTO productos (nombre, imagen, descripcion, precio) VALUES (:nombre, :imagen, :descripcion, :precio)";
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute([
                ':nombre' => $nombre,
                ':imagen' => $imagen,
                ':descripcion' => $descripcion,
                ':precio' => $precio
            ]);
            $mensaje = "¡Producto cargado con éxito!";
        } catch (PDOException $e) {
            $mensaje = "Error al cargar: " . $e->getMessage();
        }
    } else {
        $mensaje = "Por favor, completa todos los campos correctamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Producto - Cooperadora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Pahawh+Hmong&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontendnew/styles/tienda.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            background: #FFFFFF;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(14, 20, 28, 0.14);
            font-family: 'Nunito', Arial, sans-serif;
        }
        .form-container label {
            display: block;
            margin-top: 15px;
            font-weight: 700;
            color: #191d64;
        }
        .form-container input, .form-container textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #D7DCE4;
            border-radius: 8px;
            font-size: 16px;
            font-family: 'Nunito', Arial, sans-serif;
        }
        .form-container button {
            margin-top: 25px;
            width: 100%;
            padding: 14px;
            background-color: #191d64;
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .form-container button:hover {
            background-color: #12154a;
        }
        .mensaje {
            text-align: center;
            font-weight: bold;
            color: #27ae60;
            margin-bottom: 20px;
            background: #eafaf1;
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<nav>
    <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="https://eest.tecnica1vl.org/">Pagina principal</a></li>
        <li><a href="listado.php">Productos</a></li>
        <li><a href="cargar_producto.php">Cargar Producto</a></li>
        <li><a href="logout.php">Cerrar Sesión (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
    </ul>
</nav>

<main>
    <br>
    <div>
        <h1>Cargar Nuevo Producto</h1>
        <p class="descripcion">Agrega un nuevo artículo al catálogo de la cooperadora completando los siguientes datos.</p>
    </div>

    <div class="form-container">
        <?php if($mensaje): ?>
            <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <form action="cargar_producto.php" method="POST">
            <label for="nombre">Nombre del producto:</label>
            <input type="text" id="nombre" name="nombre" required placeholder="Ej. Remera EEST1">

            <label for="imagen">Ruta de la Imagen:</label>
            <input type="text" id="imagen" name="imagen" required placeholder="Ej. ../frontendnew/img/Prendas.png">

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required placeholder="Descripción breve..."></textarea>

            <label for="precio">Precio ($):</label>
            <input type="number" step="0.01" id="precio" name="precio" required placeholder="Ej. 15000">

            <button type="submit">Guardar Producto</button>
        </form>
    </div>
</main>

<footer class="pie-de-pag">
    <a href=""><img class="logo" src="../frontendnew/img/LogoEEST1png.webp" alt="logo escuela"></a>
    <div class="informacion">
        <p>Digitalizando la cooperadora</p>
        <div class="contenedor-iconos">
            <a href="https://www.instagram.com/tecnica1_vicente_lopez/"><img class="icon-ig" src="../frontendnew/img/Instagram_logo_2016.svg.png" alt="instagram"></a>
            <a href="https://www.facebook.com/tecnicauno.vicentelopez/"><img class="icon-face" src="../frontendnew/img/FacebookLOGO.png" alt="Facebook"></a>
            <a href="https://t.me/s/eest1?before=265"><img class="icon-teleg" src="../frontendnew/img/TelegramLogo.svg" alt="Telegram"></a>
        </div>
    </div>
</footer>
</body>
</html>
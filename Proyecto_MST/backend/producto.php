<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'conexion.php';

// Verificamos si pasaron el ID del producto por la URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM productos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$producto = $stmt->fetch();

if (!$producto) {
    die("Producto no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($producto['nombre']) ?> - Cooperadora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Pahawh+Hmong&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../frontendnew/styles/tienda.css">
    <style>
        .producto-individual {
            max-width: 900px;
            margin: 60px auto;
            background: #FFFFFF;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(14, 20, 28, 0.14);
            display: flex;
            flex-wrap: wrap;
            overflow: hidden;
        }
        .producto-individual img {
            width: 100%;
            max-width: 450px;
            object-fit: contain;
            background: #E7EBF1;
            padding: 30px;
        }
        .producto-detalles {
            padding: 50px 40px;
            flex: 1;
            min-width: 300px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .producto-detalles h2 {
            font-family: 'Ubuntu', Arial, sans-serif;
            color: #191d64;
            font-size: 36px;
            margin-bottom: 15px;
        }
        .producto-detalles p.precio {
            font-family: 'Ubuntu', Arial, sans-serif;
            font-size: 26px;
            color: #93887A;
            background: #EFEBE4;
            padding: 8px 20px;
            border-radius: 999px;
            display: inline-block;
            margin-bottom: 25px;
            font-weight: 700;
        }
        .producto-detalles p.desc {
            font-family: 'Nunito', Arial, sans-serif;
            color: #5B6478;
            font-size: 18px;
            line-height: 1.7;
            margin-bottom: 40px;
        }
        .btn-volver {
            text-decoration: none;
            background: #191d64;
            color: #FFFFFF;
            padding: 14px 24px;
            border-radius: 8px;
            font-family: 'Nunito', Arial, sans-serif;
            font-weight: bold;
            display: inline-block;
            text-align: center;
            transition: background 0.2s;
            width: max-content;
        }
        .btn-volver:hover {
            background: #12154a;
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
    <div class="producto-individual">
        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <div class="producto-detalles">
            <h2><?= htmlspecialchars($producto['nombre']) ?></h2>
            <p class="precio">$<?= htmlspecialchars($producto['precio']) ?></p>
            <p class="desc"><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>
            <a href="listado.php" class="btn-volver">← Volver al catálogo</a>
        </div>
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
<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once 'conexion.php';


/*
 * Verificamos que hayan enviado un ID.
 */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de producto no especificado.");
}

$id = intval($_GET['id']);


/*
 * Buscamos el producto junto con:
 *
 * - categoría
 * - imagen principal
 * - variante
 * - material
 * - color
 * - talle
 * - precio
 * - stock
 */
$sql = "
    SELECT
        p.id_producto,
        p.nombre,
        p.descripcion,

        c.nombre AS categoria,

        ip.ruta_imagen,
        ip.texto_alternativo,

        vp.id_variante,

        m.nombre AS material,
        co.nombre AS color,
        t.nombre AS talle,

        pr.precio,

        COALESCE(s.cantidad, 0) AS stock

    FROM productos p

    INNER JOIN categorias c
        ON p.id_categoria = c.id_categoria

    LEFT JOIN imagenes_producto ip
        ON p.id_producto = ip.id_producto
        AND ip.principal = 1

    LEFT JOIN variantes_producto vp
        ON p.id_producto = vp.id_producto

    LEFT JOIN materiales m
        ON vp.id_material = m.id_material

    LEFT JOIN colores co
        ON vp.id_color = co.id_color

    LEFT JOIN talles t
        ON vp.id_talle = t.id_talle

    LEFT JOIN precios pr
        ON vp.id_variante = pr.id_variante

    LEFT JOIN stock s
        ON vp.id_variante = s.id_variante

    WHERE p.id_producto = :id
    AND p.activo = 1

    LIMIT 1
";


$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$producto = $stmt->fetch();


/*
 * Si no existe el producto.
 */
if (!$producto) {
    die("Producto no encontrado.");
}

?>
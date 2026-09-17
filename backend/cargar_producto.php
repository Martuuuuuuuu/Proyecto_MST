<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

require_once "conexion.php";

$mensaje = "";

/* =========================
   CARGAR DATOS PARA LOS SELECT
   ========================= */

$categorias = $pdo->query("
    SELECT id_categoria, nombre
    FROM categorias
    ORDER BY nombre
")->fetchAll();

$materiales = $pdo->query("
    SELECT id_material, nombre
    FROM materiales
    ORDER BY nombre
")->fetchAll();

$colores = $pdo->query("
    SELECT id_color, nombre
    FROM colores
    ORDER BY nombre
")->fetchAll();

$talles = $pdo->query("
    SELECT id_talle, nombre
    FROM talles
    ORDER BY id_talle
")->fetchAll();


/* =========================
   PROCESAR FORMULARIO
   ========================= */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");

    $id_categoria = intval($_POST["id_categoria"] ?? 0);

    $id_material = !empty($_POST["id_material"])
        ? intval($_POST["id_material"])
        : null;

    $id_color = !empty($_POST["id_color"])
        ? intval($_POST["id_color"])
        : null;

    $id_talle = !empty($_POST["id_talle"])
        ? intval($_POST["id_talle"])
        : null;

    $stock = intval($_POST["stock"] ?? 0);
    $precio = floatval($_POST["precio"] ?? 0);

    $imagen = trim($_POST["imagen"] ?? "");


    /* =========================
       VALIDACIONES
       ========================= */

    if (
        $nombre === "" ||
        $id_categoria <= 0 ||
        $imagen === "" ||
        $precio <= 0 ||
        $stock < 0
    ) {

        $mensaje = "Por favor, completá correctamente los campos obligatorios.";

    } else {

        try {

            /* Iniciamos una transacción.
               Si algo falla, no se guarda nada. */

            $pdo->beginTransaction();


            /* =========================
               1. CREAR PRODUCTO
               ========================= */

            $sqlProducto = "
                INSERT INTO productos
                (id_categoria, nombre, descripcion)
                VALUES
                (:id_categoria, :nombre, :descripcion)
            ";

            $stmtProducto = $pdo->prepare($sqlProducto);

            $stmtProducto->execute([
                ":id_categoria" => $id_categoria,
                ":nombre" => $nombre,
                ":descripcion" => $descripcion
            ]);

            $id_producto = $pdo->lastInsertId();


            /* =========================
               2. CREAR VARIANTE
               ========================= */

            $sqlVariante = "
                INSERT INTO variantes_producto
                (id_producto, id_material, id_color, id_talle)
                VALUES
                (:id_producto, :id_material, :id_color, :id_talle)
            ";

            $stmtVariante = $pdo->prepare($sqlVariante);

            $stmtVariante->execute([
                ":id_producto" => $id_producto,
                ":id_material" => $id_material,
                ":id_color" => $id_color,
                ":id_talle" => $id_talle
            ]);

            $id_variante = $pdo->lastInsertId();


            /* =========================
               3. GUARDAR STOCK
               ========================= */

            $sqlStock = "
                INSERT INTO stock
                (id_variante, cantidad)
                VALUES
                (:id_variante, :cantidad)
            ";

            $stmtStock = $pdo->prepare($sqlStock);

            $stmtStock->execute([
                ":id_variante" => $id_variante,
                ":cantidad" => $stock
            ]);


            /* =========================
               4. GUARDAR PRECIO
               ========================= */

            $sqlPrecio = "
                INSERT INTO precios
                (id_variante, precio)
                VALUES
                (:id_variante, :precio)
            ";

            $stmtPrecio = $pdo->prepare($sqlPrecio);

            $stmtPrecio->execute([
                ":id_variante" => $id_variante,
                ":precio" => $precio
            ]);


            /* =========================
               5. GUARDAR IMAGEN
               ========================= */

            $sqlImagen = "
                INSERT INTO imagenes_producto
                (
                    id_producto,
                    ruta_imagen,
                    texto_alternativo,
                    principal
                )
                VALUES
                (
                    :id_producto,
                    :ruta_imagen,
                    :texto_alternativo,
                    1
                )
            ";

            $stmtImagen = $pdo->prepare($sqlImagen);

            $stmtImagen->execute([
                ":id_producto" => $id_producto,
                ":ruta_imagen" => $imagen,
                ":texto_alternativo" => $nombre
            ]);


            /* =========================
               FINALIZAR
               ========================= */

            $pdo->commit();

            $mensaje = "¡Producto cargado correctamente!";

        } catch (PDOException $e) {

            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $mensaje = "Error al cargar el producto: " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Cargar producto</title>

    <link rel="stylesheet" href="../styles/administrador.css">

</head>

<body>

    <main class="contenido-principal">

        <header class="encabezado">
            <h2>Cargar producto</h2>
        </header>

        <section class="seccion visible">

            <?php if ($mensaje !== ""): ?>

                <p>
                    <?= htmlspecialchars($mensaje) ?>
                </p>

            <?php endif; ?>


            <form method="POST">

                <label for="nombre">
                    Nombre del producto
                </label>

                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    required
                >


                <label for="descripcion">
                    Descripción
                </label>

                <textarea
                    id="descripcion"
                    name="descripcion"
                ></textarea>


                <label for="id_categoria">
                    Categoría
                </label>

                <select
                    id="id_categoria"
                    name="id_categoria"
                    required
                >

                    <option value="">
                        Seleccionar categoría
                    </option>

                    <?php foreach ($categorias as $categoria): ?>

                        <option value="<?= $categoria["id_categoria"] ?>">

                            <?= htmlspecialchars($categoria["nombre"]) ?>

                        </option>

                    <?php endforeach; ?>

                </select>


                <label for="id_material">
                    Material
                </label>

                <select
                    id="id_material"
                    name="id_material"
                >

                    <option value="">
                        Seleccionar material
                    </option>

                    <?php foreach ($materiales as $material): ?>

                        <option value="<?= $material["id_material"] ?>">

                            <?= htmlspecialchars($material["nombre"]) ?>

                        </option>

                    <?php endforeach; ?>

                </select>


                <label for="id_color">
                    Color
                </label>

                <select
                    id="id_color"
                    name="id_color"
                >

                    <option value="">
                        Seleccionar color
                    </option>

                    <?php foreach ($colores as $color): ?>

                        <option value="<?= $color["id_color"] ?>">

                            <?= htmlspecialchars($color["nombre"]) ?>

                        </option>

                    <?php endforeach; ?>

                </select>


                <label for="id_talle">
                    Talle
                </label>

                <select
                    id="id_talle"
                    name="id_talle"
                >

                    <option value="">
                        Seleccionar talle
                    </option>

                    <?php foreach ($talles as $talle): ?>

                        <option value="<?= $talle["id_talle"] ?>">

                            <?= htmlspecialchars($talle["nombre"]) ?>

                        </option>

                    <?php endforeach; ?>

                </select>


                <label for="stock">
                    Stock
                </label>

                <input
                    type="number"
                    id="stock"
                    name="stock"
                    min="0"
                    value="0"
                    required
                >


                <label for="precio">
                    Precio
                </label>

                <input
                    type="number"
                    id="precio"
                    name="precio"
                    min="0"
                    step="0.01"
                    required
                >


                <label for="imagen">
                    Ruta de la imagen
                </label>

                <input
                    type="text"
                    id="imagen"
                    name="imagen"
                    placeholder="../img/productos/producto.jpeg"
                    required
                >


                <button type="submit">
                    Cargar producto
                </button>

            </form>

        </section>

    </main>

</body>

</html>
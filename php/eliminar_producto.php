<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$conn = (new Database())->getConnection();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['producto_id'])) {
    $id = intval($_POST['producto_id']);
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $mensaje = $stmt->affected_rows > 0 ? "Producto eliminado correctamente." : "Error al eliminar el producto.";
}

$categoria_id = $_GET['categoria'] ?? null;

if ($categoria_id) {
    $stmt = $conn->prepare("SELECT id, nombre, imagen_principal FROM productos WHERE categoria_id = ?");
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $productos = $conn->query("SELECT id, nombre, imagen_principal FROM productos")->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Producto</title>
    <link rel="icon" type="image/png" href="../img_index/favicon.png">
    <link rel="stylesheet" href="../css/eliminar_producto.css">
</head>
<body>
    <header>
        <a href="../index.php"><img src="../img_index/logo.png" class="logo" alt="Logo"></a>
    </header>
 <?php

$categoria_id = $_GET['categoria'] ?? null;
$volver_a = '../index.php';

if ($categoria_id == 1) $volver_a = '../paginas/adultos.php';
elseif ($categoria_id == 2) $volver_a = '../paginas/niños.php';
elseif ($categoria_id == 3) $volver_a = '../paginas/retros.php';
?>
<a href="<?= $volver_a ?>" class="btn-volver">← Volver</a>

    <main>
        <h2 class="titulo">Eliminar Productos</h2>

        <?php if ($mensaje): ?>
            <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <div class="contenedor-productos">
            <?php foreach ($productos as $producto): ?>
                <div class="tarjeta">
                    <img src="../img productos/<?= htmlspecialchars($producto['imagen_principal']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                    <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                    <form method="POST" onsubmit="return confirm('¿Estás seguro que querés eliminar este producto?');">
                        <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                        <button type="submit" class="btn-eliminar-admin">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>

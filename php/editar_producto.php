<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$conn = (new Database())->getConnection();
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productos']) && is_array($_POST['productos'])) {
    $mensaje = '';
    foreach ($_POST['productos'] as $prod) {
        $id = intval($prod['id']);
        $precio = floatval($prod['precio']);
        $stock = intval($prod['stock']);

        $stmt = $conn->prepare("UPDATE productos SET precio = ?, stock = ?, fecha_actualizacion = NOW() WHERE id = ?");
        $stmt->bind_param("dii", $precio, $stock, $id);
        if (!$stmt->execute()) {
            $mensaje .= "Error al actualizar el producto ID $id.<br>";
        }
    }

    if (empty($mensaje)) {
        $mensaje = "Todos los productos fueron actualizados correctamente.";
    }
}

$categoria_id = $_GET['categoria'] ?? null;

if ($categoria_id) {
    $stmt = $conn->prepare("SELECT id, nombre, precio, stock, imagen_principal FROM productos WHERE categoria_id = ?");
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $productos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $productos = $conn->query("SELECT id, nombre, precio, stock, imagen_principal FROM productos")->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Producto</title>
  <link rel="icon" type="image/png" href="../img_index/favicon.png">
  <link rel="stylesheet" href="../css/editar_producto.css">
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
  <h2 class="titulo" >Editar Productos</h2>

  <?php if ($mensaje): ?>
    <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
  <?php endif; ?>

<form method="POST">
  <div class="contenedor-productos">
    <?php foreach ($productos as $producto): ?>
      <div class="tarjeta">
        <img src="../img productos/<?= htmlspecialchars($producto['imagen_principal']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>

        <input type="hidden" name="productos[<?= $producto['id'] ?>][id]" value="<?= $producto['id'] ?>">

        <label>Precio:</label>
        <input type="number" name="productos[<?= $producto['id'] ?>][precio]" value="<?= $producto['precio'] ?>" step="0.01" required>

        <label>Stock:</label>
        <input type="number" name="productos[<?= $producto['id'] ?>][stock]" value="<?= $producto['stock'] ?>" min="0" required>
      </div>
    <?php endforeach; ?>
  </div>

  <div style="text-align: center; margin: 2rem 0;">
    <button type="submit" class="btn-guardar-grande">Guardar todos los cambios</button>
  </div>
</form>

  </div>
</main>
</body>
</html>

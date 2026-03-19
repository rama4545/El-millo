<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$db = new Database();
$conn = $db->getConnection();

$categorias = $conn->query("SELECT * FROM categorias")->fetch_all(MYSQLI_ASSOC);
$subcategorias = $conn->query("SELECT * FROM subcategorias")->fetch_all(MYSQLI_ASSOC);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $precio = $_POST['precio'] ?? 0;
    $stock = $_POST['stock'] ?? 0;
    $categoria_id = $_POST['categoria_id'] ?? 0;
    $subcategoria_id = $_POST['subcategoria_id'] ?? 0;

  
    $imagen_nombre = '';
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['imagen']['tmp_name'];
        $nombre_archivo = basename($_FILES['imagen']['name']);
        $ruta_destino = '../img productos/' . $nombre_archivo;

        if (move_uploaded_file($tmp_name, $ruta_destino)) {
            $imagen_nombre = $nombre_archivo;
        } else {
            $mensaje = 'Error al subir la imagen.';
        }
    }

    if ($imagen_nombre && $categoria_id > 0 && $subcategoria_id > 0) {
        $stmt = $conn->prepare("INSERT INTO productos (nombre, precio, categoria_id, subcategoria_id, imagen_principal, stock) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdissi", $nombre, $precio, $categoria_id, $subcategoria_id, $imagen_nombre, $stock);
        
        if ($stmt->execute()) {
            header('Location: ../paginas/retros.php');
            exit;
        } else {
            $mensaje = 'Error MySQL: ' . $stmt->error;
        }
    } else {
        $mensaje = 'Por favor, completá todos los campos y cargá una imagen.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Producto</title>
  <link rel="stylesheet" href="../css/agregar_producto.css">
</head>
<body>
  <header>
    <div class="header-centro">
      <a href="../index.php"><img src="../img_index/logo.png" class="logo" alt="Logo"></a>
    </div>
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
    <form method="POST" enctype="multipart/form-data">
      <h2>Agregar Producto</h2>
      <?php if ($mensaje): ?>
        <p class="mensaje" style="color: red; text-align: center;"><?= $mensaje ?></p>
      <?php endif; ?>

      <input type="text" name="nombre" placeholder="Nombre del producto" required>
      <input type="number" name="precio" placeholder="Precio" required step="0.01">
      <input type="number" name="stock" placeholder="Stock" required>

      <label>Categoría:</label>
      <select name="categoria_id" required>
        <option value="">Seleccionar</option>
        <?php foreach ($categorias as $cat): ?>
          <option value="<?= $cat['id'] ?>"><?= $cat['nombre'] ?></option>
        <?php endforeach; ?>
      </select>

      <label>Subcategoría:</label>
      <select name="subcategoria_id" required>
        <option value="">Seleccionar</option>
        <?php foreach ($subcategorias as $sub): ?>
          <option value="<?= $sub['id'] ?>"><?= $sub['nombre'] ?></option>
        <?php endforeach; ?>
      </select>

      <label>Imagen del producto:</label>
      <input type="file" name="imagen" accept="image/png, image/jpeg" required>

      <button type="submit">Agregar producto</button>
    </form>
  </main>
</body>
</html>

<?php
require_once(__DIR__ . '/../php/Conexion.php');
session_start();
$usuarioLogueado = isset($_SESSION['usuario']);
$esAdmin = $usuarioLogueado && $_SESSION['usuario']['rol'] === 'admin';
$carrito_cantidad = 0;
if ($usuarioLogueado) {
    $conn = (new Database())->getConnection();
    $usuario_id = $_SESSION['usuario']['id'];
    $sql = "SELECT SUM(cantidad) as total FROM carrito_items ci JOIN carritos c ON ci.carritos_id = c.id WHERE c.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $carrito_cantidad = $row['total'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Retros - El Millo</title>
  <link rel="icon" type="image/png" href="../img_index/favicon.png">
  <link rel="stylesheet" href="../css/retros.css">
  <link rel="stylesheet" href="../css/carrito.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <script defer src="../js/carrito.js"></script>
    <script defer src="../js/buscar.js"></script>
</head>
<body>
<header>
  <nav>
    <a href="../index.php"><img src="../img_index/logo.png" class="logo" alt="Logo"></a>
    <form action="../php/buscar.php" class="buscar" method="get">
      <input type="text" name="q" placeholder="Buscar">
      <button type="submit"><i class="fas fa-search"></i></button>
    </form>
    <div class="iconos">
      <?php if ($usuarioLogueado): ?>
        <a href="../paginas/Perfil.php" title="Perfil"><img src="../img_index/user.png" class="user"></a>
      <?php else: ?>
        <a href="../paginas/login.php" class="btn-iniciarsesion">Iniciar sesión</a>
        <a href="paginas/registrarse.php" class="btn-iniciarsesion">Crear cuenta</a>
      <?php endif; ?>
      <div class="carrito-icono" onclick="toggleCarrito()" id="icono-carrito">
        <img src="../img_index/carrito.png" alt="Carrito" class="carrito">
        <?php if ($carrito_cantidad > 0): ?>
          <span class="contador-carrito"><?= $carrito_cantidad ?></span>
        <?php endif; ?>
      </div>
    </div>
  </nav>
</header>

<div id="carrito-lateral" class="carrito-lateral">
  <div class="carrito-header">
    <span>Carrito</span>
    <button onclick="toggleCarrito()" style="background: none; border: none; color: white; font-size: 18px;">&times;</button>
  </div>
  <div class="carrito-resumen">
    <p>Tu carrito está vacío.</p>
  </div>
</div>

<div class="alerta-agregado" id="alerta-agregado" style="display:none;"></div>
<div id="notificacion-carrito" class="notificacion" style="display:none;"></div>

<main>
<?php
$conn = (new Database())->getConnection();

$remerasRetro = $conn->query("
    SELECT * FROM productos 
    WHERE categoria_id = 3 AND subcategoria_id = 7
")->fetch_all(MYSQLI_ASSOC);

$otrosRetro = $conn->query("
    SELECT * FROM productos 
    WHERE categoria_id = 3 AND subcategoria_id IN (8,9)
")->fetch_all(MYSQLI_ASSOC);
?>

<?php if ($esAdmin): ?>
  <div class="admin-botones">
    <a href="../php/agregar_producto.php?categoria=3" class="btn-agregar">+ Agregar producto</a>
    <a href="../php/editar_producto.php?categoria=3" class="btn-editar">Editar producto</a>
<a href="../php/eliminar_producto.php?categoria=3" class="btn-eliminar-admin">Eliminar producto</a>
  </div>
<?php endif; ?>

<div class="seccion1">
  <div class="seccion-titulo">REMERAS</div>
  <section class="productos">
    <?php foreach ($remerasRetro as $producto): ?>
      <div class="retros">
        <img src="../img productos/<?= htmlspecialchars($producto['imagen_principal']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
        <p>$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
        <?php if ($esAdmin): ?>
       <p><strong>Stock:</strong> <?= $producto['stock'] ?></p>
       <?php endif; ?>
<?php if ($producto['stock'] > 0): ?>
  <button class="btn-comprar"
    data-id="<?= $producto['id'] ?>"
    data-nombre="<?= htmlspecialchars($producto['nombre']) ?>"
    data-precio="<?= $producto['precio'] ?>"
    data-img="../img productos/<?= htmlspecialchars($producto['imagen_principal']) ?>"
  >Comprar</button>
<?php else: ?>
  <button class="btn-comprar" disabled style="opacity: 0.5; cursor: not-allowed;">Sin stock</button>
<?php endif; ?>
      </div>
    <?php endforeach; ?>
  </section>
</div>

<div class="seccion2">
  <div class="seccion-titulo">PANTALONES Y SHORTS</div>
  <section class="productos">
    <?php foreach ($otrosRetro as $producto): ?>
      <div class="retros">
        <img src="../img productos/<?= htmlspecialchars($producto['imagen_principal']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
        <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
        <p>$<?= number_format($producto['precio'], 0, ',', '.') ?></p>
        <?php if ($esAdmin): ?>
        <p><strong>Stock:</strong> <?= $producto['stock'] ?></p>
        <?php endif; ?>
<?php if ($producto['stock'] > 0): ?>
  <button class="btn-comprar"
    data-id="<?= $producto['id'] ?>"
    data-nombre="<?= htmlspecialchars($producto['nombre']) ?>"
    data-precio="<?= $producto['precio'] ?>"
    data-img="../img productos/<?= htmlspecialchars($producto['imagen_principal']) ?>"
  >Comprar</button>
<?php else: ?>
  <button class="btn-comprar" disabled style="opacity: 0.5; cursor: not-allowed;">Sin stock</button>
<?php endif; ?>
      </div>
    <?php endforeach; ?>
  </section>
</div>
</main>


<div id="modal-producto" class="modal-compra oculto">
  <div class="modal-contenido">
    <span class="cerrar" onclick="cerrarModal()">&times;</span>
    <img id="modal-img" src="" alt="Producto" style="width: 100px;">
    <h3 id="modal-nombre"></h3>
    <form id="form-agregar-carrito">
      <input type="hidden" name="producto_id" id="producto_id">
      <input type="hidden" name="nombre" id="nombre">
      <input type="hidden" name="precio" id="precio">
      <label for="talle">Talle:</label>
      <select name="talle" id="talle" required>
        <option value="">Seleccionar</option>
        <option value="XS">XS</option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
        <option value="XXL">XXL</option>
      </select>
      <label for="cantidad">Cantidad:</label>
      <input type="number" name="cantidad" id="cantidad" min="1" value="1" required>
      <button type="submit">Agregar al carrito</button>
    </form>
  </div>
</div>

<footer>
  <p>&copy; 2025 EL MILLO. Todos los derechos reservados.</p>
  <div class="redes-sociales">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
  </div>
</footer>
</body>
</html>

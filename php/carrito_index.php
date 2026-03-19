<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

$db = new Database();
$conn = $db->getConnection();

if (!isset($_SESSION['usuario'])) {
  echo "<p style='padding:1rem;'>Iniciá sesión para ver tu carrito.</p>";
  exit;
}

$usuario_id = $_SESSION['usuario']['id'];

$sql = "SELECT ci.id, ci.cantidad, ci.talle, p.nombre, p.precio, p.imagen_principal
        FROM carrito_items ci
        JOIN carritos c ON ci.carritos_id = c.id
        JOIN productos p ON ci.producto_id = p.id
        WHERE c.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
  echo "<p style='padding:1rem;'>Tu carrito está vacío.</p>";
  exit;
}

$total = 0;

while($item = $res->fetch_assoc()): ?>
  <div class="carrito-item">
    <img src="./img productos/<?php echo $item['imagen_principal']; ?>" alt="Producto">
    <div class="carrito-item-detalle">
      <h4><?php echo $item['nombre']; ?></h4>
      <p>Talle: <?php echo $item['talle']; ?></p>
      <p>Cantidad: <?php echo $item['cantidad']; ?></p>
      <p>Precio unitario: $<?php echo number_format($item['precio'], 2); ?></p>
      <p>Subtotal: $<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></p>
    </div>
    <form method="POST" action="./php/eliminar_item.php">
      <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
      <button type="submit" class="btn-eliminar" title="Eliminar">🗑️</button>
    </form>
  </div>
  <?php $total += $item['precio'] * $item['cantidad']; ?>
<?php endwhile; ?>

<div class="carrito-total">
  <h3>Total: $<?php echo number_format($total, 2); ?></h3>
  <span>O hasta 6 cuotas sin interés de $<?php echo number_format($total / 6, 2); ?></span>
  <a href="./php/compra.php" class="btn-iniciar">Iniciar compra</a>
  <form method="POST" action="./php/vaciar_carrito.php">
    <button class="btn-vaciar" onclick="return confirm('¿Vaciar todo el carrito?')">Vaciar carrito</button>
  </form>
</div>


<script>
document.querySelectorAll('.btn-eliminar').forEach(boton => {
  boton.addEventListener('click', function(e) {
    e.preventDefault();

    const form = this.closest('form');
    const itemId = form.querySelector('input[name="item_id"]').value;

    fetch(form.action, {
      method: 'POST',
      body: new URLSearchParams({ item_id: itemId }),
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        // Elimina el item del DOM
        form.closest('.carrito-item').remove();

      } else {
        alert('Error al eliminar el producto');
      }
    });
  });
});
</script>

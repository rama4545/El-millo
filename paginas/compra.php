<?php
require_once(__DIR__ . '/../php/Conexion.php');
session_start();
if (!isset($_SESSION['usuario']['id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$usuario_id = $_SESSION['usuario']['id'];

$stmt = $conn->prepare("SELECT ci.cantidad, ci.talle, p.nombre, p.precio, p.imagen_principal FROM carrito_items ci JOIN carritos c ON ci.carritos_id = c.id JOIN productos p ON ci.producto_id = p.id WHERE c.usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

$items = [];
$total = 0;
while ($row = $res->fetch_assoc()) {
    $items[] = $row; 
    $total += $row['precio'] * $row['cantidad'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Compra</title>
  <link rel="icon" type="image/png" href="../img_index/favicon.png">
  <link rel="stylesheet" href="../css/compra.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <script defer src="../js/compra.js"></script>
</head>
<body>
  <header>
    <div class="header-centro">
      <a href="../index.php"><img src="../img_index/logo.png" class="logo" alt="Logo"></a>
    </div>
  </header>

  <main>
    <div class="carrito-container">
      <h2>Datos del comprador</h2>
      <form action="../php/finalizar_compra.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>

        <div class="vencimiento-grupo">
          <label>Provincias</label>
          <div class="vencimiento-selects">
            <select name="provincias" required  class="provincias">
              <option value="">Seleccione una provincia</option>
              <option value="Buenos Aires">Buenos Aires</option>
              <option value="Catamarca">Catamarca</option>
              <option value="Chaco">Chaco</option>
              <option value="Chubut">Chubut</option>
              <option value="Cordoba">Córdoba</option>
              <option value="Corrientes">Corrientes</option>
              <option value="Entre Rios">Entre Ríos</option>
              <option value="Formosa">Formosa</option>
              <option value="Jujuy">Jujuy</option>
              <option value="La Pampa">La Pampa</option>
              <option value="La Rioja">La Rioja</option>
              <option value="Mendoza">Mendoza</option>
              <option value="Misiones">Misiones</option>
              <option value="Neuquen">Neuquén</option>
              <option value="Rio Negro">Río Negro</option>
              <option value="Salta">Salta</option>
              <option value="San Juan">San Juan</option>
              <option value="San Luis">San Luis</option>
              <option value="Santa Cruz">Santa Cruz</option>
              <option value="Santa Fe">Santa Fe</option>
              <option value="Santiago Del Estero">Santiago del Estero</option>
              <option value="Tierra del Fuego">Tierra del Fuego</option>
              <option value="Tucuman">Tucumán</option>
            </select>
          </div>
        </div>

        <input type="text" name="localidad" placeholder="Localidad" required>
        <input type="text" name="direccion" placeholder="Dirección" required>
        <input type="text" name="dni" placeholder="DNI" required inputmode="numeric" maxlength="10" oninput="formatearDni(this)">
        <input type="text" name="telefono" placeholder="Teléfono" required inputmode="numeric" maxlength="12" oninput="formatearTelefono(this)">

        <h2>Información de pago</h2>

        <select name="tarjeta" required>
          <option value="">Marca de la tarjeta</option>
          <option value="Visa">Visa</option>
          <option value="Mastercard">Mastercard</option>
        </select>

        <select name="tipo_pago" id="tipo-tarjeta" required onchange="toggleCuotas()">
          <option value="">Tipo de tarjeta</option>
          <option value="debito">Débito</option>
          <option value="credito">Crédito</option>
        </select>

        <div id="opciones-cuotas" style="display: none;">
          <label for="cuotas">Cuotas:</label>
          <select name="cuotas">
            <option value="1">1 cuota</option>
            <option value="3">3 cuotas</option>
            <option value="6">6 cuotas</option>
            <option value="12">12 cuotas</option>
          </select>
        </div>

        <input type="text" name="tarjeta_numero" placeholder="Número de tarjeta" required pattern="(?:\d{4}-){3}\d{4}" maxlength="19" inputmode="numeric" oninput="formatearTarjeta(this)">
        <input type="text" name="tarjeta_nombre" placeholder="Nombre del titular" required pattern="[A-Za-z ]{3,50}">

        <div class="vencimiento-grupo">
          <label>Fecha de vencimiento</label>
          <div class="vencimiento-selects">
            <select name="mes" required>
              <option value="">Mes</option>
              <?php for ($i = 1; $i <= 12; $i++): ?>
                <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
              <?php endfor; ?>
            </select>

            <select name="anio" required>
              <option value="">Año</option>
              <?php
                $anio_actual = date("Y");
                for ($i = 0; $i <= 10; $i++):
                  $anio = $anio_actual + $i;
              ?>
                <option value="<?= $anio ?>"><?= $anio ?></option>
              <?php endfor; ?>
            </select>
          </div>
        </div>

        <input type="text" name="tarjeta_cvv" placeholder="CVV" required pattern="\d{3,4}" maxlength="4" inputmode="numeric">
        <div class="error-container">
          <p id="mensaje-error" class="mensaje-error" style="display: none;"></p>
        </div>

        <h2>Productos en tu carrito</h2>
        <div class="carrito-items">
          <?php foreach($items as $item): ?>
            <div class="item">
              <img src="../img productos/<?= htmlspecialchars($item['imagen_principal']) ?>" alt="Producto">
              <div class="detalle">
                <h3><?= htmlspecialchars($item['nombre']) ?></h3>
                <p>Talle: <?= htmlspecialchars($item['talle']) ?></p>
                <p>Cantidad: <?= htmlspecialchars($item['cantidad']) ?></p>
                <p>Precio unitario: $<?= number_format($item['precio'], 2) ?></p>
                <p>Subtotal: $<?= number_format($item['precio'] * $item['cantidad'], 2) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <div class="total">Total: $<?= number_format($total, 2) ?></div>
        <button type="submit" class="btn-comprar">Confirmar compra</button>
      </form>
    </div>
  </main>

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

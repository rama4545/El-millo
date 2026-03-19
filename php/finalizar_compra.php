<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if (!isset($_SESSION['usuario']['id'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$usuario_id = $_SESSION['usuario']['id'];

$nombre    = $_POST['nombre'] ?? '';
$email     = $_POST['email'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$localidad = $_POST['localidad'] ?? '';
$provincias = $_POST['provincias'] ?? '';
$dni       = $_POST['dni'] ?? '';
$telefono  = $_POST['telefono'] ?? '';
$tarjeta_numero = $_POST['tarjeta_numero'] ?? '';
$tarjeta_nombre = $_POST['tarjeta_nombre'] ?? '';
$tarjeta = $_POST['tarjeta'] ?? '';
$tipo_pago = $_POST['tipo_pago'] ?? '';
$cuotas    = $_POST['cuotas'] ?? '1';
$mes       = (int) ($_POST['mes'] ?? 0);
$anio      = (int) ($_POST['anio'] ?? 0);
$cvv       = $_POST['tarjeta_cvv'] ?? '';
$detalle_pago = $_POST['detalle_pago'] ?? '';

if (
    !$nombre || !$email || !$localidad || !$provincias || !$direccion || !$dni || !$telefono ||
    !$tarjeta_numero || !$tarjeta_nombre || !$tarjeta || !$tipo_pago || !$cuotas || !$mes || !$anio || !$cvv
) {
    echo "<p>Faltan datos. Completá todos los campos.</p>";
    exit;
}

$fecha_actual = new DateTime();
$fecha_vencimiento = DateTime::createFromFormat('Y-m', sprintf('%04d-%02d', $anio, $mes));
if (!$fecha_vencimiento || $fecha_vencimiento < new DateTime('first day of this month')) {
    echo "<p style='color: red; font-weight: bold; text-align: center;'>Error: La tarjeta está vencida. Por favor, ingresá una válida.</p>";
    exit;
}

$stmt = $conn->prepare("SELECT id FROM carritos WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
$carrito = $res->fetch_assoc();

if (!$carrito) {
    echo "<p>No tenés productos en tu carrito.</p>";
    exit;
}

$carrito_id = $carrito['id'];

$stmt = $conn->prepare("INSERT INTO compras (usuario_id, nombre, email, localidad, provincias, direccion, telefono, dni, fecha)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
$stmt->bind_param("isssssss", $usuario_id, $nombre, $email, $localidad, $provincias, $direccion, $telefono, $dni);
$stmt->execute();
$orden_id = $stmt->insert_id;

$stmt = $conn->prepare("SELECT producto_id, cantidad, talle FROM carrito_items WHERE carritos_id = ?");
$stmt->bind_param("i", $carrito_id);
$stmt->execute();
$res = $stmt->get_result();

$total = 0;

while ($item = $res->fetch_assoc()) {
    $producto_id = $item['producto_id'];

    $stmt_precio = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt_precio->bind_param("i", $producto_id);
    $stmt_precio->execute();
    $res_precio = $stmt_precio->get_result();
    $row_precio = $res_precio->fetch_assoc();
    $precio = $row_precio['precio'];

    $stmt_item = $conn->prepare("INSERT INTO compra_items (orden_id, producto_id, talle, cantidad, precio_unitario)
                                 VALUES (?, ?, ?, ?, ?)");
    $stmt_item->bind_param("iisid", $orden_id, $producto_id, $item['talle'], $item['cantidad'], $precio);
    $stmt_item->execute();

    $stmt_descuento = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
    $stmt_descuento->bind_param("iii", $item['cantidad'], $producto_id, $item['cantidad']);
    $stmt_descuento->execute();

    $total += $item['cantidad'] * $precio;
}

$conn->query("DELETE FROM carrito_items WHERE carritos_id = $carrito_id");

$_POST['compra_id']     = $orden_id;
$_POST['total']         = $total;
$_POST['nombre']        = $nombre;
$_POST['email']         = $email;
$_POST['localidad']     = $localidad;
$_POST['provincias']     = $provincias;
$_POST['direccion']     = $direccion;
$_POST['telefono']      = $telefono;
$_POST['tarjeta']       = $tarjeta;
$_POST['tipo_pago']     = $tipo_pago;
$_POST['cuotas']        = $cuotas;
$_POST['detalle_pago']  = $detalle_pago;

include('enviar_factura.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Compra Exitosa</title>
  <link rel="icon" type="image/png" href="../img_index/favicon.png">
  <link rel="stylesheet" href="../css/finalizar_compra.css">
</head>
<body>
  <div class="contenedor">
    <img src="../img_index/logo.png" alt="Logo El Millo" class="logo">
    <h2>¡Compra realizada con éxito! 🛒</h2>
    <p>Gracias por tu compra. Tu factura te estara llegando a tu gmail.</p>
    <p><strong>Número de orden:</strong> #<?= $orden_id ?></p>
    <a href="../index.php" class="boton-volver">Volver al inicio</a>
  </div>
</body>
</html>

<?php
require_once(__DIR__ . '/Conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario']['id'])) {
    echo json_encode(['success' => false, 'error' => 'Inicie sesion para comprar']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$producto_id = $_POST['producto_id'] ?? null;
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$talle = $_POST['talle'] ?? '';
$cantidad = $_POST['cantidad'] ?? 1;


if (!$producto_id || !$talle || $cantidad < 1) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$usuario_id = $_SESSION['usuario']['id'];

$stmt = $conn->prepare("SELECT id FROM carritos WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $carrito_id = $res->fetch_assoc()['id'];
} else {
    $stmt = $conn->prepare("INSERT INTO carritos (usuario_id) VALUES (?)");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $carrito_id = $stmt->insert_id;
}
$stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$res = $stmt->get_result();
$producto = $res->fetch_assoc();

if (!$producto || $producto['stock'] < $cantidad) {
    echo json_encode(['success' => false, 'error' => 'Stock insuficiente']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO carrito_items (carritos_id, producto_id, talle, cantidad) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iisi", $carrito_id, $producto_id, $talle, $cantidad);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
echo json_encode(['success' => false, 'error' => 'No se pudo agregar el producto: ' . $stmt->error]);
}

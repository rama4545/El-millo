<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "0";
    exit;
}

$db = new Database();
$conn = $db->getConnection();
$usuario_id = $_SESSION['usuario']['id'];

$sql = "SELECT SUM(cantidad) as total FROM carrito_items ci
        JOIN carritos c ON ci.carritos_id = c.id
        WHERE c.usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

echo $row['total'] ?? "0";

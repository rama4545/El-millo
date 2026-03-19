<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: ../paginas/login.php');
    exit;
}

$conn = (new Database())->getConnection();
$usuario_id = $_SESSION['usuario']['id'];

$sql = "SELECT id FROM carritos WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $carrito = $res->fetch_assoc();
    $carrito_id = $carrito['id'];

    $delete = $conn->prepare("DELETE FROM carrito_items WHERE carritos_id = ?");
    $delete->bind_param("i", $carrito_id);
    $delete->execute();
}

header('Location: ' . $_SERVER['HTTP_REFERER']); 
exit;
?>

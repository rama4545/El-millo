<?php
require_once(__DIR__ . '/Conexion.php');
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_id = $_POST['item_id'] ?? null;
    $usuario_id = $_SESSION['usuario']['id'];

    if (!$item_id) {
        echo json_encode(['success' => false, 'error' => 'ID inválido']);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("
        DELETE ci FROM carrito_items ci
        JOIN carritos c ON ci.carritos_id = c.id
        WHERE ci.id = ? AND c.usuario_id = ?
    ");
    $stmt->bind_param("ii", $item_id, $usuario_id);
    $stmt->execute();

    echo json_encode(['success' => $stmt->affected_rows > 0]);
} else {
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
}


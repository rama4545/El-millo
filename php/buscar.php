<?php
require_once(__DIR__ . '/Conexion.php');

if (!isset($_GET['q']) || trim($_GET['q']) === '') {
    header("Location: ../index.php");
    exit;
}

$q = strtolower(trim($_GET['q']));

$db = new Database();
$conn = $db->getConnection();

$sql = "
    SELECT p.id, p.nombre, c.nombre AS categoria 
    FROM productos p
    JOIN categorias c ON p.categoria_id = c.id
    WHERE LOWER(p.nombre) LIKE CONCAT('%', ?, '%')
       OR LOWER(c.nombre) LIKE CONCAT('%', ?, '%')
    LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $q, $q);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $categoria = strtolower($row['categoria']);

    switch ($categoria) {
        case 'adultos':
            header("Location: ../paginas/adultos.php#producto-" . $row['id']);
            break;
        case 'niños':
        case 'ninos':
            header("Location: ../paginas/niños.php#producto-" . $row['id']);
            break;
        case 'retros':
            header("Location: ../paginas/retros.php#producto-" . $row['id']);
            break;
        default:
            header("Location: ../index.php");
    }
    exit;
}

$sql = "SELECT nombre FROM categorias WHERE LOWER(nombre) = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $q);
$stmt->execute();
$res = $stmt->get_result();

if ($row = $res->fetch_assoc()) {
    $categoria = strtolower($row['nombre']);
    switch ($categoria) {
        case 'adultos':
            header("Location: ../paginas/adultos.php");
            break;
        case 'niños':
        case 'ninos':
            header("Location: ../paginas/niños.php");
            break;
        case 'retros':
            header("Location: ../paginas/retros.php");
            break;
        default:
            header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php?no_encontrado=1");
}
exit;

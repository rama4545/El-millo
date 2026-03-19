<?php
require_once(__DIR__ . '/Conexion.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    if (empty($usuario) || empty($clave)) {
        echo "<script>alert('Por favor completá todos los campos.'); window.location.href='../paginas/login.php';</script>";
        exit;
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? LIMIT 1");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarioEncontrado = $result->fetch_assoc();

        if ($usuarioEncontrado && password_verify($clave, $usuarioEncontrado['clave'])) {
            $_SESSION['usuario'] = [
                'id' => $usuarioEncontrado['id'],
                'usuario' => $usuarioEncontrado['usuario'],
                'nombre' => $usuarioEncontrado['nombre'],
                'apellido' => $usuarioEncontrado['apellido'],
                'email' => $usuarioEncontrado['email'],
                'foto_perfil' => $usuarioEncontrado['foto_perfil'],
                'rol' => $usuarioEncontrado['rol'] 
            ];

            header('Location: ../index.php');
            exit;
        } else {
            header("Location: ../paginas/login.php?error=Usuario o contraseña incorrectos");
            exit;
        }
    } catch (Exception $e) {
        echo "<script>alert('Error en la conexión a la base de datos.');</script>";
    }
} else {
    header('Location: ../paginas/login.php');
    exit;
}

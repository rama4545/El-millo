<?php
require_once 'Conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $confirmar_clave = $_POST['confirmar_clave'] ?? '';

    $_SESSION['form'] = $_POST; 

    $errores = [];

    if (empty($usuario)) $errores[] = "El nombre de usuario es requerido.";
    if (empty($email)) $errores[] = "El email es requerido.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "Email inválido.";
    if (empty($nombre)) $errores[] = "El nombre es requerido.";
    if (empty($apellido)) $errores[] = "El apellido es requerido.";
    if (empty($clave)) $errores[] = "La contraseña es requerida.";
    if (strlen($clave) < 6) $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    if ($clave !== $confirmar_clave) $errores[] = "Las contraseñas no coinciden.";

    if (empty($errores)) {
        try {
            $db = new Database();
            $conexion = $db->getConnection();
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
            $stmt->bind_param('ss', $usuario, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                header("Location: ../paginas/registrarse.php?error=El usuario o email ya están registrados.");
                exit;
            } else {
                $clave_hash = password_hash($clave, PASSWORD_DEFAULT);

                $insert = $conexion->prepare("INSERT INTO usuarios (usuario, email, nombre, apellido, clave) VALUES (?, ?, ?, ?, ?)");
                $insert->bind_param('sssss', $usuario, $email, $nombre, $apellido, $clave_hash);

                if ($insert->execute()) {
                    $user_id = $conexion->insert_id;

                    $carrito = $conexion->prepare("INSERT INTO carritos (usuario_id) VALUES (?)");
                    $carrito->bind_param('i', $user_id);
                    $carrito->execute();
                    $carrito->close();

                    unset($_SESSION['form']); 
                    header('Location: ../paginas/login.php');
                    exit;
                } else {
                    header("Location: ../paginas/registrarse.php?error=Error al registrar usuario.");
                    exit;
                }

                $insert->close();
            }

            $stmt->close();
            $conexion->close();
        } catch (Exception $e) {
            error_log("Error de registro: " . $e->getMessage());
            header("Location: ../paginas/registrarse.php?error=Error del sistema. Intente nuevamente.");
            exit;
        }
    } else {
        $mensaje = implode(" ", $errores);
        header("Location: ../paginas/registrarse.php?error=" . urlencode($mensaje));
        exit;
    }
} else {
    header('Location: ../paginas/registrarse.php');
    exit;
}
?>
